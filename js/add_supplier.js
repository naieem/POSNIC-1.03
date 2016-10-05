/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

        /*$.validator.setDefaults({
         submitHandler: function() { alert("submitted!"); }
         });*/
        $(document).ready(function () {

            // validate signup form on keyup and submit
            $("#form1").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 200
                    },
                    address: {
                        minlength: 3,
                        maxlength: 500
                    },
                    contact1: {
                        minlength: 10,
                        maxlength: 20
                    },
                    contact2: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a supplier Name",
                        minlength: "Supplier must consist of at least 3 characters"
                    },
                    address: {
                        minlength: "Supplier Address must be at least 3 characters long",
                        maxlength: "Supplier Address must be at least 3 characters long"
                    },
                    contact1: {
                        required: "Please enter a contact number",
                        minlength: "contact number must consist of at least 10 characters",
                        maxlength: "contact number consist of at least 13 characters"
                    }
                }
            });

        });

   


