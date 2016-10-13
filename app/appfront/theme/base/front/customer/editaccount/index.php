<div class="main container two-columns-left">
	
	<div class="col-main account_center">
		<div class="std">
			<div style="margin:19px 0 0">
				<div class="page-title">
					<h2>Edit Account Information</h2>
				</div>
				<form method="post" id="form-validate" autocomplete="off" action="<?=  $actionUrl ?>">
					<?= \fec\helpers\CRequest::getCsrfInputHtml();  ?>
					<div class="">
						<ul class="">
							<li>
								<label for="email" class="required">Email Address</label>
								<div class="input-box">
									
									<input style="color:#ccc;" readonly="true" id="customer_email" name="editForm[email]" value="<?= $email ?>" title="Email" maxlength="255" class="input-text required-entry" type="text">
									
								</div>
							</li>
							<li class="">
								
									<div class="field name-firstname">
										<label for="firstname" class="required">First Name</label>
										<div class="input-box">
											<input id="firstname" name="editForm[first_name]" value="<?= $firstname ?>" title="First Name" maxlength="255" class="input-text required-entry" type="text">
											<div class="validation-advice" id="required_current_firstname" style="display:none;">This is a required field.</div>
										</div>
									</div>
							</li>
							<li>
								<div class="field name-lastname">
										<label for="lastname" class="required">Last Name</label>
										<div class="input-box">
											<input id="lastname" name="editForm[last_name]" value="<?= $lastname ?>" title="Last Name" maxlength="255" class="input-text required-entry" type="text">
											<div class="validation-advice" id="required_current_lastname" style="display:none;">This is a required field.</div>
										</div>
									</div>
							</li>
							<li class="control">
								<input name="editForm[change_password]" id="change_password" value="1" onclick="setPasswordForm(this.checked)" title="Change Password" class="checkbox" type="checkbox">
								<label style="display:inline;vertical-align: middle;" for="change_password">Change Password</label>
							</li>
						</ul>
					</div>
				
					<div class="" id="fieldset_pass" style="display:none;">
						
						<ul class="form-list">
							<li>
								<label style="font-weight:100;" for="current_password" class="required">Current Password</label>
								<div class="input-box">
									<input title="Current Password" class="input-text required-entry" name="editForm[current_password]" id="current_password" type="password">
									<div class="validation-advice" id="required_current_password" style="display:none;">This is a required field.</div>
								</div>
							</li>
							<li class="fields">
								<div class="field">
									<label style="font-weight:100;" for="password" class="required">New Password</label>
									<div class="input-box">
										<input title="New Password" class="input-text validate-password required-entry" name="editForm[password]" id="password" type="password">
										<div class="validation-advice" id="required_new_password" style="display:none;">This is a required field.</div>
									</div>
								</div>
								<div class="field">
									<label style="font-weight:100;" for="confirmation" class="required"><em>*</em>Confirm New Password</label>
									<div class="input-box">
										<input title="Confirm New Password" class="input-text validate-cpassword required-entry" name="editForm[confirmation]" id="confirmation" type="password">
										<div class="validation-advice" id="required_confirm_password" style="display:none;">This is a required field.</div>
									</div>
								</div>
								<div class="clear"></div>
							</li>
						</ul>
					</div>
					<div class="buttons-set">
						<button onclick="return check_edit()" type="submit" id="js_registBtn" class="redBtn"><em><span><i></i>SAVE</span></em></button>
						
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="col-left ">
		<?php
			$leftMenu = [
				'class' => 'fecshop\app\appfront\modules\Customer\block\LeftMenu',
				'view'	=> 'customer/leftmenu.php'
			];
		?>
		<?= Yii::$service->page->widget->render($leftMenu,$this); ?>
	</div>
	<div class="clear"></div>
</div>

<script>
<?php $this->beginBlock('customer_account_info_update') ?> 
	function setPasswordForm(arg){
        if(arg){
            $('#fieldset_pass').show();
        }else{
            $('#fieldset_pass').hide();
        }
    }
    function check_edit(){
        $check_current_password = true;
        $check_new_password = true;
        $check_confir_password = true;
		$check_current_firstname = true;
		$check_current_lastname = true;
		
		$firstname = $('#firstname').val();
		$lastname = $('#lastname').val();
		$check_confir_password_with_pass = true;
		
		if($firstname == ''){
		   $('#firstname').addClass('validation-failed');
		   $('#required_current_firstname').show();
		   $check_current_firstname = false;
		}else{
		   $('#firstname').removeClass('validation-failed');
		   $('#required_current_firstname').hide();
		   $check_current_firstname = true;
		}
		
		if($lastname == ''){
		   $('#lastname').addClass('validation-failed');
		   $('#required_current_lastname').show();
		   $check_current_lastname = false;
		}else{
		   $('#lastname').removeClass('validation-failed');
		   $('#required_current_lastname').hide();
		   $check_current_lastname = true;
		}
		
        if($('#change_password').is(':checked')){
            $current_password = $('#current_password').val();
            $password = $('#password').val();
            $confirmation = $('#confirmation').val();
            if($current_password == ''){
               $('#current_password').addClass('validation-failed');
               $('#required_current_password').show();
               $check_current_password = false;
            }else{
               $('#current_password').removeClass('validation-failed');
               $('#required_current_password').hide();
               $check_current_password = true;
            }
            if($password == ''){
               $('#password').addClass('validation-failed');
               $('#required_new_password').show().html('This is a required field.');;
               $check_new_password = false;
            }else{
                if(!checkPass($password)){
                    $('#password').addClass('validation-failed');
                    $('#required_new_password').show();
                    $('#required_new_password').html('Must have 6 to 30 characters and no spaces.');
                    $check_new_password = false;
                }else{
                    $('#password').removeClass('validation-failed');
                    $('#required_new_password').hide();
                    $check_new_password = true;
                }
            }
			
            if($confirmation == ''){
               $('#confirmation').addClass('validation-failed');
               $('#required_confirm_password').show().html('This is a required field.');
               $check_confir_password = false;
            }else{
                if(!checkPass($confirmation)){
                    $('#confirmation').addClass('validation-failed');
                    $('#required_confirm_password').show();
                    $('#required_confirm_password').html('Must have 6 to 30 characters and no spaces.');
                    $check_confir_password = false;
                 }else{
					if($password != $confirmation){
						$('#confirmation').addClass('validation-failed');
						$('#required_confirm_password').show();
						$('#required_confirm_password').html('Two password is not the same！');
						$check_confir_password_with_pass = false;
					}else{
						$('#confirmation').removeClass('validation-failed');
						$('#required_confirm_password').hide();
						$check_confir_password = true;
					}
                    
                }
            }
		}
	 
		if( $check_confir_password_with_pass && $check_current_firstname && $check_current_lastname && $check_confir_password && $check_new_password && $check_current_password){
			return true;
		}else{
			return false;
		}
	}
	
	function checkPass(str){
        var re = /^\w{6,30}$/;
         if(re.test(str)){
           return true;
        }else{
           return false;
        }
    }
    function checkEmail(str){  
        var myReg = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/; 
        if(myReg.test(str)) return true; 
        return false; 
    } 
<?php $this->endBlock(); ?>  
</script>  
<?php $this->registerJs($this->blocks['customer_account_info_update'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

	