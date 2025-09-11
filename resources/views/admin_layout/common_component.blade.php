<div id="delete-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <i class="ri-alert-line h1 text-danger"></i>
                <h4 class="mt-2">Are you sure?</h4>
                <p class="mt-3">Do you really want to delete this record?</br> This action cannot be undone.</p>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDelete" class="btn btn-danger">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        //delete model start
        let deleteUrl = '';
        $(document).on('click', '#delete_model_btn', function(e) {
            e.preventDefault();
            deleteUrl = $(this).data('delete_url');
            $('#confirmDelete').attr('href', deleteUrl);
            var myModal = new bootstrap.Modal(document.getElementById('delete-alert-modal'));
            myModal.show();
        });
        //delete model end
    });

    //toaster message start
    @if(Session::has('success'))
    $.toast({
        heading: 'Success',
        text: "{{ Session::get('success') }}",
        showHideTransition: 'slide',
        icon: 'success',
        position: 'top-center',
        loaderBg: '#159488',
        hideAfter: 3000
    });
    @endif

    @if(Session::has('error'))
    $.toast({
        heading: 'Error',
        text: "{{ Session::get('error') }}",
        showHideTransition: 'slide',
        icon: 'error',
        position: 'top-center',
        loaderBg: '#de4034',
        hideAfter: 3000
    });
    @endif

    @if(Session::has('warning'))
    $.toast({
        heading: 'Warning',
        text: "{{ Session::get('warning') }}",
        showHideTransition: 'slide',
        icon: 'warning',
        position: 'top-center',
        loaderBg: '#e5af0c',
        hideAfter: 3000
    });
    @endif

    @if(Session::has('info'))
    $.toast({
        heading: 'Info',
        text: "{{ Session::get('info') }}",
        showHideTransition: 'slide',
        icon: 'info',
        position: 'top-center',
        loaderBg: '#258cdd',
        hideAfter: 3000
    });
    @endif
    //toaster message end
</script>