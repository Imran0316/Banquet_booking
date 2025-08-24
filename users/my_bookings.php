<?php
session_start();
include("../db.php");
include("include/header.php");
$page = "inner";
include("include/navbar.php");
// ensure user logged in
if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

$userId = (int) $_SESSION['id'];

// fetch bookings for this user (most recent first)
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare("
    SELECT
      bookings.id,
      bookings.date,
      bookings.time_slot AS booking_time,
      bookings.status AS booking_status,
      bookings.created_at,
      banquets.name AS banquet_name,
      banquets.price,
      users.name AS user_name
          FROM bookings
    JOIN banquets ON bookings.banquet_id = banquets.id
    JOIN users ON bookings.user_id = users.id
    WHERE bookings.user_id = ?
    ORDER BY bookings.date DESC, bookings.id DESC
");
$stmt->execute([$userId]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// helper for booking code
function booking_code($id)
{
  return 'WTS' . str_pad($id, 4, '0', STR_PAD_LEFT);
}

?>

<style>
  :root {
    --c1: #28b6c1;
    --c2: #13a0ab;
    --stub: #fff;
    --muted: #e9fbfd;
    --shadow: 0 8px 28px rgba(12, 40, 45, .12);
    --fs-location: clamp(.9rem, 2.2vw, 1.05rem);
    --fs-clock: clamp(.95rem, 2.2vw, 1.04rem);
    --fs-meta: clamp(.78rem, 1.9vw, .9rem);
    --stub-w: 124px;
    --notch-r: 18px;
  }

  body {
    background: #f5f9fb;

    font-family: system-ui, Segoe UI, Roboto, Arial;
    margin: 0
  }

  .ticket {
    /* show whole element normally */
    -webkit-mask-image:
      radial-gradient(circle var(--notch-r) at calc(100% - var(--stub-w) + 6px) 4px, transparent 60%, black 61%),
      radial-gradient(circle var(--notch-r) at calc(100% - var(--stub-w) + 6px) calc(100% - 4px), transparent 60%, black 61%),
      linear-gradient(#000, #000);
    /* fallback, keep rest visible */
    mask-image:
      radial-gradient(circle var(--notch-r) at calc(100% - var(--stub-w) + 6px) 4px, transparent 60%, black 61%),
      radial-gradient(circle var(--notch-r) at calc(100% - var(--stub-w) + 6px) calc(100% - 4px), transparent 60%, black 61%),
      linear-gradient(#000, #000);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    /* may need vendor tweaks per browser */
    background: white;
    /* ticket bg */
  }

  .ticket {
    display: flex;
    max-width: 720px;
    margin: 0 auto;
    background: #fff;
    border-radius: 14px;
    overflow: visible;
    box-shadow: var(--shadow)
  }

  .left {
    flex: 1;
    padding: 20px 22px;
    border-top-left-radius: 14px;
    border-bottom-left-radius: 14px;
    background: #0000FF;
    color: #fff
  }

  .location {
    display: flex;
    gap: 10px;
    align-items: center;
    font-weight: 700;
    font-size: 1.05rem
  }

  .flag {
    width: 28px;
    height: 18px;
    border-radius: 3px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .08)
  }

  .time {
    margin-top: 12px;
    display: flex;
    gap: 12px;
    align-items: center
  }

  .clock {
    font-weight: 700;
    font-size: 1.05rem
  }

  .meta {
    margin-top: 18px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 18px
  }

  .meta .id {
    font-size: .9rem;
    color: rgba(255, 255, 255, .9)
  }

  .price {
    font-weight: 800;
    font-size: 1.05rem;
    background: rgba(255, 255, 255, .12);
    padding: .35rem .7rem;
    border-radius: .6rem
  }

  .stub {
    width: 120px;
    background: var(--stub);
    display: flex;
    flex-direction: column;
    align-items: center;
    border-left: 2px dotted #0000FF;
    justify-content: center;
    padding: 12px 10px;
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
    box-shadow: inset -6px 0 20px rgba(0, 0, 0, .03)
  }

  .stub .day {
    font-size: .75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .06em
  }

  .stub .date {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a;
    margin-top: 6px
  }

  .stub .month {
    font-size: .8rem;
    color: #0f172a;
    margin-top: 2px;
    font-weight: 700
  }

  /* .ticket::before,
  .ticket::after {
    content: "";
    width: 28px;
    height: 28px;
    background: #f5f9fb;
    position: absolute;
    right: 105px;
    border-radius: 50%;
    z-index: 2;
    box-shadow: 0 2px 4px rgba(0, 0, 0, .02)
  }

  .ticket::before {
    top: -14px
  }

  .ticket::after {
    bottom: -14px
  } */
  /* ---------- MOBILE ADJUSTMENTS (keep row layout but scale down) ---------- */
  /* Use breakpoints to reduce padding/sizes but keep same structure */
  @media (max-width:540px) {
    :root {
      --fs-location: .94rem;
      --fs-clock: .95rem;
      --fs-meta: .74rem;
    }

    /* slightly smaller left padding and stub width */
    .left {
      padding: 10px 12px;
    }

    .location {
      gap: 8px
    }

    .flag {
      width: 22px;
      height: 14px
    }

    .time {
      gap: 8px
    }

    .meta {
      margin-top: 10px
    }

    .price {
      padding: .28rem .5rem;
      font-size: .82rem
    }

    /* stub smaller but keep on right */
    .stub {
      width: 84px;
      padding: 8px
    }

    .stub .date {
      font-size: 1.25rem
    }

    .ticket::before,
    .ticket::after {
      right: 78px;
      width: 20px;
      height: 20px;
      top: -10px;
      bottom: -10px;
    }

    /* ensure text wraps & left panel shrinks instead of stacking */
    .left {
      min-width: 0
    }

    .ticket {
      flex-wrap: nowrap
    }

    /* important: prevent stacking to column */
  }

  /* final fallback for very very small screens (if absolutely needed) */
  @media (max-width:360px) {
    .left {
      padding: 8px 10px
    }

    .stub {
      width: 72px
    }

    .flag {
      width: 20px;
      height: 12px
    }

    .stub .date {
      font-size: 1.05rem
    }
  }
</style>
<div class="container">
  <h3 class="m-5 text-center">Your Bookings</h3>

  <div id="alerts" class="alert-area"></div>

  <?php if (empty($bookings)): ?>
    <div class="card p-3 mb-3 ">You have no bookings yet.</div>
  <?php endif; ?>

  <?php foreach ($bookings as $b):
    $status = $b['booking_status'];
    $badgeClass = $status === 'cancelled' ? 'badge-cancelled' : ($status === 'pending' ? 'badge-pending' : 'badge-confirmed');
    $date = $b['date'] ?: $b['created_at'];
    $dt = new DateTime($date);
    ?>
    <div class="ticket position-relative my-5" data-id="<?= (int) $b['id'] ?>">
      <div class="left">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="location">
              <span class="flag">
                <i class="fa-brands fa-fort-awesome-alt fs-3"
                  style="width:100%;height:100%;object-fit:cover;display:block"></i></span>
              <span style="margin-left:6px;"><?= htmlspecialchars($b['banquet_name']) ?> ·
                <?= htmlspecialchars($b['user_name']) ?></span>
            </div>

            <div class="time">
              <div>
                <div class="clock"><?= htmlspecialchars($b['booking_time']) ?: 'N/A' ?></div>
                <div style="font-size:.82rem;color:rgba(255,255,255,.95)">Time</div>
              </div>

              <div class="ms-auto text-end" style="color:rgba(255,255,255,.85);font-size:.88rem">
                <div>Booking ID</div>
                <div style="font-weight:700"><?= booking_code($b['id']) ?></div>
              </div>
            </div>
          </div>
        </div>

        <div class="meta">
          <div class="id">Booked on <span
              style="opacity:.95;margin-left:6px;font-weight:700"><?= htmlspecialchars($dt->format('Y-m-d')) ?></span>
          </div>
          <div>
            <span class="price"><?= htmlspecialchars($b['price'] ?: '—') ?></span>
            <span class="badge <?= $badgeClass ?>"
              style="margin-left:10px;padding:.45rem .6rem;border-radius:.5rem"><?= ucfirst($status) ?></span>
          </div>
        </div>
      </div>

      <div class="stub">
        <div class="day"><?= htmlspecialchars($dt->format('M')) ?></div>
        <div class="date"><?= htmlspecialchars($dt->format('d')) ?></div>
        <div class="month" style="margin-top:6px;font-weight:600;color:#64748b"><?= htmlspecialchars($dt->format('Y')) ?>
        </div>
      </div>
    </div>



  <?php endforeach; ?>
</div>


<?php
include("../includes/footer.php");
?>