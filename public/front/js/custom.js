$(document).ready(function(){
	$(".loader").hide();
	$("#getPrice").change(function(){
		var size = $(this).val();
		var product_id = $(this).attr("product-id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			url:'/get-product-price',
			data:{size:size,product_id:product_id},
			type:'post',
			success:function(resp){
                //if ever na di ko maayos ung orignal price ung pinakauna ang original price nalang ilalagay 
				if(resp['discount']>0){
					$(".getAttributePrice").html("<div class='price'><h4>₱ "+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price: </span><span>₱ "+resp['product_price']+"</span></div>");
				}//else if(selectedSize !== ""){             
				//	$(".getAttributePrice").html("<div class='price'><h4>₱ {{ $productDetails['product_price'] }}</h4></div>");
				//}
                else{                    
                    $(".getAttributePrice").html("<div class='price'><h4>₱ "+resp['final_price']+"</h4></div>");
                }
            
			},error:function(){
				alert("Error");
			}
		});
	});

	// Update Cart Item Quantity
	$(document).on('click','.updateCartItem',function(){
		if($(this).hasClass('plus-a')){
			//Get quantity
			var quantity = $(this).data('qty');
			//Increase the quantity by 1
			new_qty = parseInt(quantity) + 1;
			/*alert(new_qty);*/
		}
		if($(this).hasClass('minus-a')){
			//Get quantity
			var quantity = $(this).data('qty');
			// Check if quantity is atleast 1
			if(quantity<=1){
				alert("Item quantity must be 1 or greater!");
				return false;
			}

			//Increase the quantity by 1
			new_qty = parseInt(quantity) - 1;
			/*alert(new_qty);*/
		}
		var cartid = $(this).data('cartid');
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			data:{cartid:cartid,qty:new_qty },
			url:'/cart/update',
			type:'post',
			success:function(resp){
				$(".totalCartItems").html(resp.totalCartItems);
				if(resp.status==false){
					alert(resp.message);
				}
				$("#appendCartItems").html(resp.view);
				$("#appendHeaderCartItems").html(resp.headerview);
			},error:function(){
				alert("Error");
			}
		});
	});

	// Delete Cart Items 
	$(document).on('click','.deleteCartitem',function(){
		var cartid = $(this).data('cartid');
		var result = confirm("Are you sure to delete this Cart Item?");
		if(result){
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data:{cartid:cartid},
				url:'/cart/delete',
				type:'post',
				success:function(resp){
					$(".totalCartItems").html(resp.totalCartItems);
					$("#appendCartItems").html(resp.view);
					$("#appendHeaderCartItems").html(resp.headerview);
				},error:function(){
					alert("Error");
				}
	
			})
		}
	});

	// Register Form Validation
	$("#registerForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			  		
			url:"/user/register",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#register-"+i).attr('style','color:red');
						$("#register-"+i).html(error);
			
					setTimeout(function(){
						$("#register-"+i).css({
							'display':'none'
						});
					},3000);
				});	
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$("#register-success").attr('style','color:green');
					$("#register-success").html(resp.message);				

				}			
			},error:function(){
				alert("Error");
			}
		})
	});	

	// Account Form Validation
	$("#accountForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
					
			url:"/user/account",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#account-"+i).attr('style','color:red');
						$("#account-"+i).html(error);
			
					setTimeout(function(){
						$("#account-"+i).css({
							'display':'none'
						});
					},3000);
				});	
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$("#account-success").attr('style','color:green');
					$("#account-success").html(resp.message);				
					setTimeout(function(){
						$("#account-success").css({
							'display':'none'
						});
					},4000);

				}			
			},error:function(){
				alert("Error");
			}
		})
	});	

	// Password Form Validation
	$("#passwordForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
					
			url:"/user/update-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#password-"+i).attr('style','color:red');
						$("#password-"+i).html(error);
						
					setTimeout(function(){
						$("#password-"+i).css({
							'display':'none'
						});
					},3000);
				});	
				}else if(resp.type=="incorrect"){
					$(".loader").hide();
						$("#password-error").attr('style','color:red');
						$("#password-error").html(resp.message);
						
					setTimeout(function(){
						$("#password-error").css({
							'display':'none'
						});
					},3000);
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$("#password-success").attr('style','color:green');
					$("#password-success").html(resp.message);				
					setTimeout(function(){
						$("#password-success").css({
							'display':'none'
						});
					},4000);

				}			
			},error:function(){
				alert("Error");
			}
		})
	});	

	// Login Form Validation
	$("#loginForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			
			url:"/user/login",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#login-"+i).attr('style','color:red');
						$("#login-"+i).html(error);
			
					setTimeout(function(){
						$("#login-"+i).css({
							'display':'none'
						});
					},3000);
				});	
				}else if(resp.type=="incorrect"){
					$(".loader").hide();
					$("#login-error	").attr('style','color:red');
					$("#login-error	").html(resp.message);
				}else if(resp.type=="inactive"){
					$(".loader").hide();
					$("#login-error	").attr('style','color:red');
					$("#login-error	").html(resp.message);
				}else if(resp.type=="success"){
					$(".loader").hide();
					window.location.href = resp.url;
				}		
							
			},error:function(){
				alert("Error");
			}
		})
	});	

	// Forgot Password Form Validation
	$("#forgotForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			  		
			url:"/user/forgot-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#forgot-"+i).attr('style','color:red');
						$("#forgot-"+i).html(error);
			
					setTimeout(function(){
						$("#register-"+i).css({
							'display':'none'
						});
					},3000);
				});	
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$("#forgot-success").attr('style','color:green');
					$("#forgot-success").html(resp.message);				

				}			
			},error:function(){
				alert("Error");
			}
		})
	});	

	// Edit Delivery Address
	$(document).on('click','.editAddress', function(){
		var addressid = $(this).data("addressid");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			data:{addressid:addressid},
			url:'/get-delivery-address',
			type:'post',
			success:function(resp){
				$("#showdifferent").removeClass("collapse");
				$(".newAddress").hide();
				$(".deliveryText").text("Edit Delivery Address");
				$('[name=delivery_id]').val(resp.address['id']);
				$('[name=delivery_name]').val(resp.address['name']);
				$('[name=delivery_address]').val(resp.address['address']);
				$('[name=delivery_city]').val(resp.address['city']);
				$('[name=delivery_state]').val(resp.address['state']);
				$('[name=delivery_country]').val(resp.address['country']);
				$('[name=delivery_zipcode]').val(resp.address['zipcode']);
				$('[name=delivery_mobile]').val(resp.address['mobile']);
			},error:function(){
				alert("Error");
			}
		});
	});

	// Save Delivery Address
	$(document).on('submit',"#addressAddEditForm", function(){
		$(".loader").show();
		var formdata = $('#addressAddEditForm').serialize();
		$.ajax({
			url: '/save-delivery-address',
			type:'post',
			data:formdata,
			success:function(resp){
				$(".loader").hide();
				if(resp.type=="error"){
					$.each(resp.errors,function(i,error){
						$("#delivery-"+i).attr('style','color:red');
						$("#delivery-"+i).html(error);
			
					setTimeout(function(){
						$("#delivery-"+i).css({
							'display':'none'
						});
					},3000);
				});	
				}else{
					$("#deliveryAddreses").html(resp.view);	
				}
			},error:function(){
				$(".loader").hide();
				alert("Error")
			}
		});
	});

	// Remove Delivery Address
	$(document).on('click','.removeAddress',function(){
		$(".loader").show();
		if(confirm("Are you sure you want to remove this?"))
		var addressid = $(this).data("addressid");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			url:'/remove-delivery-address',
			type:'post',
			data:{addressid:addressid},
			success:function(resp){
				$(".loader").hide();
				$("#deliveryAddreses").html(resp.view);	
			},error:function(){

				alert("Error");
			}
		});
	});


});


$(document).ready(function () {
    // Handle click event on "New Arrivals" link
    $("#newArrivalsLink").on("click", function (e) {
        e.preventDefault();

        // Get the target section
        var targetSection = $("#newArrivalsSection");

        // Move the content to the target section
        targetSection.append($("men-latest-products"));

        // Scroll to the target section
        $("html, body").animate({
            scrollTop: targetSection.offset().top
        }, 1000);
    });
});

function get_filter(class_name){
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}
