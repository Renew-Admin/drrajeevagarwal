let $mo = jQuery;
$mo(document).ready(function () {
    $mo("form.forminator-custom-form").each(function () {
    	let form = $mo(this);
        let formId = form.find("input[name='form_id']").val();

        // fieldID = moforminator.otpType;

        if (formId in moforminator.formDetails) {
        	
            moforminator.otpType.forEach(function (a) {
                addButtonAndFields(formId, a);
                bindSendOTPButton(formId, a);
                bindVerifyButton(formId, a);
                is_already_verified(formId, a);
            });
        }
    });
});
function is_already_verified(b, a) {
    if (moforminator.validated[a]) {
        $mo("#mo_send_otp_" + a + b)
            .val("✔")
            .attr("disabled", true);
        $mo("#mo_send_otp_" + a + b).attr("style", "background:green !important;width:auto;padding: 12px 5px;color: #ffffff;");
    }
}
function addButtonAndFields(b, a) {
	
    let containerCSS = 'style="margin-top:10px;"';
    let buttonCSS = 'style="margin:0px;"';
    let messageBox = '<div  class="vfb-item" id="mo_message' + a + b + '" hidden="" style="width:auto; background-color: #f7f6f7;padding: 1em 2em 1em 3.5em; text-align: center;margin-top:3px;"></div>';
    let verifyField ='<div id="mo_verify-container' +a +b +'" hidden="" class="forminator-field" ><label class="forminator-label" for="mo_verify_otp">' +moforminator.fieldText +'</label><input type="text" id="mo_verify_otp_' +a +b +'" class="forminator-input"name="mo_verify_otp" /></div>';
    
    let verifyOTPButton ='<div id = "forminator-field' +a +b +'" class = "forminator-field" hidden="" ' +containerCSS +
        '"><input  type = "button" name = "mo_verify_button_' +a +b +'" class = "forminator-button forminator-button-submit"  id = "mo_verify_button_'+a +b +
        '" ' +buttonCSS +' value = "Verify OTP"/></div >';
    
    let sendOTPButton = '<div class = "forminator-field" ' +containerCSS +
        '><input  type = "button" name = "mo_send_otp_' +
        a +b +'" class = "forminator-button forminator-button-submit" id = "mo_send_otp_' +a +b +'"' +
        buttonCSS +' value = "' +moforminator.buttontext +'"/></div >';

    let html = sendOTPButton + messageBox + verifyField + verifyOTPButton;
    let insertAfterselector = $mo("input[name='"+moforminator.formDetails[b][a + "key"]+"']").parent();
    
    $mo(html).insertAfter(insertAfterselector);
}
function bindSendOTPButton(b, a) {
    img = "<img alt='' src='" + moforminator.imgURL + "'>";
    $mo("#mo_send_otp_" + a + b).click(function () {
        var c = $mo("input[name='"+moforminator.formDetails[b][a + "key"]+"']").val();
        $mo("#mo_message" + a + b).empty();
        $mo("#mo_message" + a + b).append(img);
        $mo("#mo_message" + a + b).show();
        $mo.ajax({
            url: moforminator.siteURL,
            type: "POST",
            data: { user_email: c, user_phone: c, otpType: a, security: moforminator.gnonce, action: moforminator.gaction },
            crossDomain: !0,
            dataType: "json",
            success: function (d) {
                if (d.result === "success") {
                    $mo("#mo_message" + a + b).empty();
                    $mo("#mo_message" + a + b).append(d.message);
                    $mo("#mo_message" + a + b).css("border-top", "3px solid green");
                    $mo("#mo_verify-container" + a + b+",#forminator-field"+a +b).show();
                } else {
                    $mo("#mo_message" + a + b).empty();
                    $mo("#mo_message" + a + b).append(d.message);
                    $mo("#mo_message" + a + b).css("border-top", "3px solid red");
                }
            },
            error: function (d) {},
        });
    });
}
function bindVerifyButton(b, a) {
    img = "<img alt='' src='" + moforminator.imgURL + "'>";
    $mo("#mo_verify_button_" + a + b).click(function () {
        var d = $mo("#mo_verify_otp_" + a + b).val();
        var c = $mo("input[name='"+moforminator.formDetails[b][a + "key"]+"']").val();
        $mo("#mo_message" + a + b).empty();
        $mo("#mo_message" + a + b).append(img);
        $mo("#mo_message" + a + b).show();
        $mo.ajax({
            url: moforminator.siteURL,
            type: "POST",
            data: { user_email: c, user_phone: c, otp_token: d, otpType: a, security: moforminator.vnonce, action: moforminator.vaction },
            crossDomain: !0,
            dataType: "json",
            success: function (e) {
                if (e.result === "success") {
                    $mo("#mo_message" + a + b).hide();
                    $mo("#mo_verify-container" + a + b+",#forminator-field"+a +b ).hide();
                    $mo("#mo_send_otp_" + a + b).val("✔").attr("disabled", true);
                    $mo("#mo_send_otp_" + a + b).attr("style", "background:green !important;width:auto;margin:0;padding: 7px 5px;margin-top: 1px;color: #ffffff;");
                } else {
                    $mo("#mo_message" + a + b).empty();
                    $mo("#mo_message" + a + b).append(e.message);
                    $mo("#mo_message" + a + b).css("border-top", "3px solid red");
                }
            },
            error: function (e) {},
        });
    });
}
