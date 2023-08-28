<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Customer</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmail">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobile">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
            </div>
        </div>
    </div>
</div>

<script>
   async function Save(){
        let customerName = document.getElementById('customerName').value;
        let customerEmail = document.getElementById('customerEmail').value;
        let customerMobile = document.getElementById('customerMobile').value;
        if(customerName.length === 0 ){
            errorToast("Customer Name is required!")
        }
        else if(customerEmail.length === 0 ){
            errorToast("Customer Email is required!")
        }
        else if(customerMobile.length === 0 ){
            errorToast("Customer Mobile is required!")
        }
        else{
            document.getElementById('modal-close').click();
            showLoader();
            let res = await axios.post("/create-customer", {name:customerName, email:customerEmail, mobile:customerMobile});
            hideLoader();
            if (res.status === 201){
                successToast("Request Completed");
                document.getElementById('save-form').reset();
                // list refresh
                await getList();
            }
            else{
                errorToast("Request Fail !")
            }
        }
    }
</script>
