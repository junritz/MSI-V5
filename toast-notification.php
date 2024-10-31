<!--====================================== TOAST SUCCESS NOTIFICATION SECTION  ===================================-->
<div class="toast position-fixed end-0 top-0 m-2" id="successToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" style="z-index: 99999">
  <div class="toast-header bg-success d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
      <i class="fa-regular fa-circle-check text-white fs-5"></i>
      <h6 class="m-0 text-white fw-normal">Success Notification</h6>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body bg-white rounded" id="toast-message">
    <!-- DYNAMIC MESSAGE -->
  </div>
</div>

<!--====================================== TOAST ERROR NOTIFICATION SECTION  ===================================-->
<div class="toast position-fixed end-0 top-0 m-2" id="errorToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" style="z-index: 99999">
  <div class="toast-header bg-warning d-flex align-items-center justify-content-between">
    <div class="d-flex aling-items-center gap-2">
      <i class="fa-solid fa-triangle-exclamation text-black fs-5"></i>
      <h6 class="m-0 text-black fw-normal">Error Notification</h6>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body bg-white rounded" id="error-toast-message">
    <!-- DYNAMIC MESSAGE -->
  </div>
</div>

<!--====================================== MODAL PROCESSING SECTION  ===================================-->
<div class="modal" id="process-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="processModalLabel">Processing...</h1>
      </div>
      <div class="modal-body d-flex align-items-center justify-content-center gap-4 flex-column pb-5">
        <p class="text-center mb-2">This may take a few moments, please hold on.</p>
        <div class="custom-loader"></div>
      </div>
    </div>
  </div>
</div>


<!--====================================== SENDING EMAIL MODAL ===================================-->
<div class="modal email-modal" id="send-email-modal" tabindex="-1" aria-labelledby="release-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-center border-0">
        <h5 class="modal-title fw-bold sending-text m-0" id="release-modal-label">Sending <span class="dots"></span></h5>
      </div>

      <div class="modal-body text-center d-flex align-items-center justify-content-center flex-column pb-5">
        <div class="img-container">
          <img src="assets/images/email-icon.png" class="w-100 h-auto" alt="Email Icon">
        </div>

        <!-- Notification Text -->
        <p class="text-muted m-0" id="modal-notification-text"></p>
        <p class="fw-bold email-address" id="email-address"></p>
      </div>
    </div>
  </div>
</div>



