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
      banquets.capacity,
      banquets.location AS banquet_address,
      banquets.image AS banquet_image,
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

  .ticket:hover {
    scale: 1.05;
    transition: all 0.3s ease-in-out;
  }

  .left {
    flex: 1;
    padding: 20px 22px;
    border-top-left-radius: 14px;
    border-bottom-left-radius: 14px;
    background: maroon;
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
    border-left: 2px dotted maroon !important;
    justify-content: center;
    padding: 12px 10px;
    border: 1px solid maroon;
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
    box-shadow: inset -6px 0 20px goldenrod;
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



<div class="container d-flex flex-column px-3">
  <h3 class="m-4 text-center">Your Bookings</h3>

  <div id="alerts" class="alert-area text-center">
      <?php if (isset($_SESSION["success"])) {
        echo '<small class="text-denger">' . $_SESSION["success"] . '</small>';
        unset($_SESSION["success"]);
      } elseif (isset($_SESSION["error"])) {
        echo '<small class="text-danger">' . htmlspecialchars($_SESSION["error"]) . '</small>';
        unset($_SESSION["error"]);
      } ?>
  </div>

  <?php if (empty($bookings)): ?>
    <div class="card p-3 mb-3 ">You have no bookings yet.</div>
  <?php endif; ?>

  <?php foreach ($bookings as $b):
    $status = $b['booking_status'];
    $badgeClass = $status === 'cancelled' ? 'badge-cancelled' : ($status === 'pending' ? 'badge-pending' : 'badge-confirmed');
    $date = $b['date'] ?: $b['created_at'];
    $dt = new DateTime($date);
    ?>
    <button type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#bookingDetailsModal">
      <div class="ticket position-relative my-3" data-id="<?= (int) $b['id'] ?>">
        <div class="left">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="location">
                <span class="flag">
                  <i class="fa-brands fa-fort-awesome-alt fs-3"
                    style="width:100%;height:100%;object-fit:cover;display:block;color: goldenrod;"></i></span>
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
          <div class="month" style="margin-top:6px;font-weight:600;color:#64748b">
            <?= htmlspecialchars($dt->format('Y')) ?>
          </div>
        </div>
      </div>
    </button>



  <?php endforeach; ?>
</div>

<?php
include("include/footer.php");
?>

<!-- Booking Details Modal -->
<div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-labelledby="bookingDetailsModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0 rounded-4">

      <!-- Modal Header -->
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="bookingDetailsModalLabel">Booking Details</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <div class="row g-4 align-items-center">

          <!-- Left Side - Banquet Info -->
          <div class="col-md-7">
            <h4 class="fw-bold text-maroon mb-3">Royal Palace Banquet</h4>
            <ul class="list-unstyled small text-muted">
              <li><i class="bi bi-geo-alt-fill text-warning me-2"><?php echo $b["banquet_address"] ?></i></li>
              <li><i class="bi bi-people-fill text-warning me-2"></i> Capacity: <?php echo $b["capacity"] ?></li>
              <li><i class="bi bi-currency-dollar text-warning me-2"></i> Price: <?php echo $b["price"] ?></li>
              <li><i class="bi bi-calendar-check text-warning me-2"></i> Date: <?php echo $b["date"] ?></li>
              <li><i class="bi bi-clock-fill text-warning me-2"></i> Time Slot: <?php echo $b["booking_time"] ?></li>
            </ul>
          </div>

          <!-- Right Side - Image -->
          <div class="col-md-5 text-center">
            <img src="../<?php echo $b["banquet_image"] ?>" alt="Banquet Image" class="img-fluid rounded-3 shadow-sm">
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
        <form method="POST" action="cancelBooking.php" id="cancelForm">
          <input type="hidden" name="booking_id" value="<?php echo $b["id"]; ?>">
          <button type="submit" class="btn btn-danger">Cancel Booking</button>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Extra Styling -->
<style>
  .text-maroon {
    color: #800000;
  }

  .modal-content {
    background: #fffdf8;
    /* soft off-white for premium look */
  }

  .btn-danger {
    background-color: #800000;
    border: none;
  }

  .btn-danger:hover {
    background-color: #a52a2a;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const bookingDetailsModal = document.getElementById('bookingDetailsModal');
    const modalTitle = bookingDetailsModal.querySelector('.modal-title');
    const modalBody = bookingDetailsModal.querySelector('.modal-body');
    const cancelForm = document.getElementById('cancelForm');

    document.querySelectorAll('.ticket').forEach(ticket => {
      ticket.addEventListener('click', function () {
        const bookingId = this.getAttribute('data-id');

        // Debug: Log booking ID to ensure correct data-id is set
        console.log('Clicked booking ID:', bookingId);

        // Fetch booking details dynamically
        fetch(`get_booking_details.php?booking_id=${bookingId}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            // Debug: Log fetched data to ensure correct response
            console.log('Fetched booking details:', data);

            // Update modal content
            modalTitle.textContent = `Booking Details - ${data.banquet_name}`;
            modalBody.innerHTML = `
              <div class="row g-4 align-items-center">
                <div class="col-md-7">
                  <h4 class="fw-bold text-maroon mb-3">${data.banquet_name}</h4>
                  <ul class="list-unstyled small text-muted">
                    <li><i class="bi bi-geo-alt-fill text-warning me-2"></i> ${data.banquet_address}</li>
                    <li><i class="bi bi-people-fill text-warning me-2"></i> Capacity: ${data.capacity}</li>
                    <li><i class="bi bi-currency-dollar text-warning me-2"></i> Price: ${data.price}</li>
                    <li><i class="bi bi-calendar-check text-warning me-2"></i> Date: ${data.date}</li>
                    <li><i class="bi bi-clock-fill text-warning me-2"></i> Time Slot: ${data.booking_time}</li>
                  </ul>
                </div>
                <div class="col-md-5 text-center">
                  <img src="../${data.banquet_image}" alt="Banquet Image" class="img-fluid rounded-3 shadow-sm">
                </div>
              </div>`;

            // Update cancel form booking ID
            cancelForm.querySelector('input[name="booking_id"]').value = bookingId;
          })
          .catch(error => {
            console.error('Error fetching booking details:', error);
            modalBody.innerHTML = '<p class="text-danger">Failed to load booking details. Please try again later.</p>';
          });
      });
    });
  });
</script>

