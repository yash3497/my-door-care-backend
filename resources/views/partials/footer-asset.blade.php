 <!-- jquery -->
 <script src="{{ asset('public/frontend') }}/js/jquery-3.6.0.js"></script>
 <!-- bootstrap js -->
 <script src="{{ asset('public/frontend') }}/js/bootstrap.bundle.js"></script>
 <!-- swipper js -->
 <script src="{{ asset('public/frontend') }}/js/swiper.js"></script>
 <!-- odometer js -->
 <script src="{{ asset('public/frontend') }}/js/odometer.js"></script>
 <!-- lightcase js-->
 <script src="{{ asset('public/frontend') }}/js/lightcase.js"></script>
 <!-- pace js-->
 <script src="{{ asset('public/frontend') }}/js/pace.js"></script>
 <!-- smooth scroll js -->
 <script src="{{ asset('public/frontend') }}/js/smoothscroll.js"></script>
 <!-- select2 js -->
 <script src="{{ asset('public/frontend') }}/js/select2.js"></script>
 <!--  Popup -->
 <script src="{{ asset('public/backend/library/popup/jquery.magnific-popup.js') }}"></script>
 <script>
     var fileHolderAfterLoad = {};
 </script>
<!-- file holder js -->
<script src="https://appdevs.cloud/cdn/fileholder/v1.0/js/fileholder-script.js" type="module"></script>
<script>
    var fileHolderAfterLoad = {};
</script>
<script type="module">
    import { fileHolderSettings } from "https://appdevs.cloud/cdn/fileholder/v1.0/js/fileholder-settings.js";
    import { previewFunctions } from "https://appdevs.cloud/cdn/fileholder/v1.0/js/fileholder-script.js";

    var inputFields = document.querySelector(".file-holder");
    fileHolderAfterLoad.previewReInit = function(inputFields) {
        previewFunctions.previewReInit(inputFields)
    };

    fileHolderSettings.urls.uploadUrl = "{{ setRoute('fileholder.upload') }}";
    fileHolderSettings.urls.removeUrl = "{{ setRoute('fileholder.remove') }}";
</script>
<script>
    function fileHolderPreviewReInit(selector) {
        var inputField = document.querySelector(selector);
        fileHolderAfterLoad.previewReInit(inputField);
    }
</script>

 <!-- nice-select -->
 <script src="{{ asset('public/frontend') }}/js/jquery.nice-select.js"></script>
 <!-- asos -->
 <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
 {{-- notify --}}
 <script src="{{ asset('public/frontend') }}/js/bootstrap-notify.js"></script>
 <!-- main -->
 <script src="{{ asset('public/frontend') }}/js/main.js"></script>

 <script>
     AOS.init({
         duration: 1200,
     });
 </script>
 <script src="{{ asset('public/frontend') }}/js/jquery.nice-select.js"></script>
 <script>
     $("select").niceSelect()
 </script>
 <script>
     var swiper = new Swiper(".mySwiper4", {
         slidesPerView: 4,
         spaceBetween: 40,
         freeMode: true,
         autoplay: {
             delay: 6000,
             disableOnInteraction: false
         },
         breakpoints: {
             '480': {
                 slidesPerView: 1,
                 spaceBetween: 30,
             },
             '768': {
                 slidesPerView: 2,
                 spaceBetween: 20,
             },
             '820': {
                 slidesPerView: 3,
                 spaceBetween: 20,
             },
             '1404': {
                 slidesPerView: 3,
                 spaceBetween: 20,
             },
             '975': {
                 slidesPerView: 2,
                 spaceBetween: 20,
             },

         },
     });
 </script>
 {{-- nanny --}}
 <script>
     function laravelCsrf() {
         return $("head meta[name=csrf-token]").attr("content");
     }
     //for popup
     function openAlertModal(URL, target, message, actionBtnText = "Remove", method = "DELETE") {
         if (URL == "" || target == "") {
             return false;
         }

         if (message == "") {
             message = "Are you sure to delete ?";
         }
         var method = `<input type="hidden" name="_method" value="${method}">`;
         openModalByContent({
                 content: `<div class="card modal-alert border-0">
                        <div class="card-body">
                            <form method="POST" action="${URL}">
                                <input type="hidden" name="_token" value="${laravelCsrf()}">
                                ${method}
                                <div class="head mb-3">
                                    ${message}
                                    <input type="hidden" name="target" value="${target}">
                                </div>
                                <div class="foot d-flex align-items-center justify-content-between">
                                    <button type="button" class="modal-close btn btn--info rounded text-light">Close</button>
                                    <button type="submit" class="alert-submit-btn btn btn--danger btn-loading rounded text-light">${actionBtnText}</button>
                                </div>
                            </form>
                        </div>
                    </div>`,
             },

         );
     }

     function openModalByContent(data = {
         content: "",
         animation: "mfp-move-horizontal",
         size: "medium",
     }) {
         $.magnificPopup.open({
             removalDelay: 500,
             items: {
                 src: `<div class="white-popup mfp-with-anim ${data.size ?? "medium"}">${data.content}</div>`, // can be a HTML string, jQuery object, or CSS selector
             },
             callbacks: {
                 beforeOpen: function() {
                     this.st.mainClass = data.animation ?? "mfp-move-horizontal";
                 },
                 open: function() {
                     var modalCloseBtn = this.contentContainer.find(".modal-close");
                     $(modalCloseBtn).click(function() {
                         $.magnificPopup.close();
                     });
                 },
             },
             midClick: true,
         });
     }
 </script>
 <script>
     $(".langSel").on("change", function() {
         window.location.href = "{{ route('index') }}/change/" + $(this).val();
     });
 </script>
