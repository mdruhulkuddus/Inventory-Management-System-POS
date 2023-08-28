<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Customer</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">


                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn btn-sm  btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function FillUpUpdateForm(id){
        document.getElementById('updateID').value = id;
        showLoader();
        let res = await axios.post("/customer-by-id",{id:id});
        // alert(res)
        hideLoader();
        document.getElementById('customerNameUpdate').value = res.data['name'];
        document.getElementById('customerEmailUpdate').value = res.data['email'];
        document.getElementById('customerMobileUpdate').value = res.data['mobile'];
    }

    async function Update(){
        let customerName = document.getElementById('customerNameUpdate').value;
        let customerEmail = document.getElementById('customerEmailUpdate').value;
        let customerMobile = document.getElementById('customerMobileUpdate').value;
        let updateID = document.getElementById('updateID').value;

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
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/update-customer", {name:customerName, email:customerEmail, mobile:customerMobile, id:updateID});
            hideLoader();
            if (res.status === 200 && res.data === 1){
                successToast("Request Completed");
                // list refresh
                await getList();
            }
            else{
                errorToast("Request Fail!")
            }
        }
    }
</script>


<script>


    //
    // async function Update() {
    //
    //     let customerName = document.getElementById('customerNameUpdate').value;
    //     let customerEmail = document.getElementById('customerEmailUpdate').value;
    //     let customerMobile = document.getElementById('customerMobileUpdate').value;
    //     let updateID = document.getElementById('updateID').value;
    //
    //
    //     if (customerName.length === 0) {
    //         errorToast("Customer Name Required !")
    //     }
    //     else if(customerEmail.length===0){
    //         errorToast("Customer Email Required !")
    //     }
    //     else if(customerMobile.length===0){
    //         errorToast("Customer Mobile Required !")
    //     }
    //     else {
    //
    //         document.getElementById('update-modal-close').click();
    //
    //         showLoader();
    //
    //         let res = await axios.post("/update-customer",{name:customerName,email:customerEmail,mobile:customerMobile,id:updateID})
    //
    //         hideLoader();
    //
    //         if(res.status===200 && res.data===1){
    //
    //             successToast('Request completed');
    //
    //             document.getElementById("update-form").reset();
    //
    //             await getList();
    //         }
    //         else{
    //             errorToast("Request fail !")
    //         }
    //     }
    // }

</script>
