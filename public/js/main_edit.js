let branchTab = 0;
let addressTab = 1;
let phoneTab = 2;
let emailTab = 3;
let taxTab = 4;
let providerTab = 5;
let reportTab = 6;

let currentTab = branchTab;
var branch = {
    type : "",
    name : "",
    timezone : "",
    radius : "",
    multi_reg : false,
    noskill : false,
    timeformat : "12"
}

let address = {
    "type" : "",
    "city" : "",
    "zip" : "",
    "address1" : "",
    "address2" : "",
}

var address_arr = []; 
var phone_arr = [];
var email_arr = [];
var tax_arr = [];
var provider_arr = [];

let addressForm = $($('.tab')[addressTab]).find('.address-row').first().clone();
let phoneForm = $($('.tab')[phoneTab]).find('.phone-row').first().clone();
let emailForm = $($('.tab')[emailTab]).find('.email-row').first().clone();
let taxForm = $($('.tab')[taxTab]).find('.tax-row').first().clone();

//Output Branch
showTab(currentTab);
function analyzeBranch()
{
    let $tabs = $('.tab');
    let $branchTab = $tabs[0];

    branch.type = $($branchTab).find('#branch_type').val();
    branch.name = $($branchTab).find('#branch_name').val();
    branch.timezone = $($branchTab).find('#branch_timezone').val();
    branch.radius = $($branchTab).find('#branch_radius').val();
    branch.multi_reg = $($branchTab).find('#branch_mulreg').is(':checked');
    branch.noskill = $($branchTab).find('#branch_noskill').is(':checked');
    branch.timeformat = $($branchTab).find("input[name='branch_time']:checked").val();
    

    let $branchDiv = $('#branch')[0];
    
    let $bName = $($branchDiv).find('input[name="br_name"]');
    let $bType = $($branchDiv).find('input[name="br_type"]');
    let $bTimezone = $($branchDiv).find('input[name="br_timezone"]');
    let $bRadius = $($branchDiv).find('input[name="br_radius"]');
    let $bMulReg = $($branchDiv).find('input[name="br_mulreg"]');
    let $branch_noskill = $($branchDiv).find('input[name="br_noskill"]');
    let $branch_timeformat1 = $($branchDiv).find('#br_time12');
    let $branch_timeformat2 = $($branchDiv).find('#br_time24');

    $bName.val(branch.name);
    $bType.val(branch.type);
    $bTimezone.val(branch.timezone);
    $bRadius.val(branch.radius);
    if(branch.timeformat == '12')
    {
        $($branch_timeformat1).prop("checked", true);
        $($branch_timeformat2).prop("checked", false);
    }    
    else if(branch.timeformat == '24')
    {
        $($branch_timeformat1).prop("checked", false);
        $($branch_timeformat2).prop("checked", true);
    }
    
    $($bMulReg).prop('checked', branch.multi_reg);
    $($branch_noskill).prop('checked', branch.noskill);
}
//Output Address
function analyzeAddress() {
    let $tabs = $('.tab');
    let $addressTab = $tabs[1];
    let $addressList = $($addressTab).find('.address-row');
    $addressList.each(function (e) {
        let $currentAddress = $($addressList[e])

        var new_add = {
            "type" : "",
            "city" : "",
            "county" : "",
            "zip" : "",
            "address1" : "",
            "address2" : "",
        };
        new_add.type = $currentAddress.find('#address_type').val();
        new_add.city = $currentAddress.find('#address_city').val();
        new_add.county = $currentAddress.find('#address_county').val();
        new_add.zip = $currentAddress.find('#address_zip').val();
        new_add.address1 = $currentAddress.find('#address_1').val();
        new_add.address2 = $currentAddress.find('#address_2').val();


        let $addressDiv = $("#address")[0];
        
        $last = $($addressDiv).find('.address-row').last();
        $address_content = $($last).clone();

        // if(new_add.type == 'o')
        //     $($address_content).find('#add_type').val('Office');
        // else if(new_add.type == 's')
        //     $($address_content).find('#add_type').text('Shipping');
        // else if(new_add.type == 'm')
        //     $($address_content).find('#add_type').text('Mail');
        // else if(new_add.type == 'b')
        //     $($address_content).find('#add_type').text('Billing'); 
        // else 
        //     $($address_content).find('#add_type').text('Office');

        $($address_content).find('select[name="add_type"]').val(new_add.type);
        $($address_content).find('input[name="add_1"]').val(new_add.address1);
        $($address_content).find('input[name="add_2"]').val(new_add.address2);
        $($address_content).find('input[name="add_city"]').val(new_add.city);
        $($address_content).find('input[name="add_county"]').val(new_add.county);
        $($address_content).find('input[name="add_zip"]').val(new_add.zip);
        $($address_content).css('display', 'block');
        $last.after($address_content);
        //let $addressDiv = $("#address")[0];

        // $last.after($html);
        address_arr.push(new_add);
    })
}

//Output Phone
function analyzePhone() {
    let $tabs = $('.tab');
    let $phoneTab = $tabs[2];
    let $list = $($phoneTab).find('.phone-row');
    $list.each(function (e) {
        let $current = $($list[e])
        var new_phone = {
            "type" : "",
            "number" : "",
        };
        new_phone.type = $current.find('#phone_type').val();
        new_phone.number = $current.find('#phone_number').val();
        $_type = '';
        if(new_phone.type == 'o')
            $_type = 'Office';
        else if(new_phone.type == 'f')
            $_type = 'Fax';
       
        let $targetDiv = $("#phone")[0];
        $last = $($targetDiv).find('.phone-row').last();
        $_content = $($last).clone();
        $($_content).find('select[name="ph_type"]').val(new_phone.type);
        $($_content).find('input[name="ph_number"]').val(new_phone.number);
        $last.after($_content);
        $($_content).css('display', 'block');
        phone_arr.push(new_phone);
    })
}

//Output Email
function analyzeEmail() {
    let $tabs = $('.tab');
    let $emailTab = $tabs[3];
    let $list = $($emailTab).find('.email-row');
    $list.each(function (e) {
        let $current = $($list[e])
        var new_email = {
            "type" : "",
            "address" : "",
        };
        new_email.type = $current.find('#email_type').val();
        new_email.address = $current.find('#email_address').val();
        
        $_type = '';
        if(new_email.type == 'o')
            $_type = 'Office';
        else if(new_email.type == 's')
            $_type = 'Support';
        
        let $targetDiv = $("#email")[0];
        $last = $($targetDiv).find('.email-row').last();
        $_content = $($last).clone();
        $($_content).find('select[name="em_type"]').val(new_email.type);
        $($_content).find('input[name="em_address"]').val(new_email.address);
        $($_content).css('display', 'block');
        $last.after($_content);
        email_arr.push(new_email);
    })
}

//Output Tax
function analyzeTax() {
    let $tabs = $('.tab');
    let $taxTab = $tabs[4];
    let $list = $($taxTab).find('.tax-row');
    $list.each(function (e) {
        let $current = $($list[e])
        var new_tax = {
            "type" : "",
            "percent" : 0,
        };
        new_tax.type = $current.find('#tax_type').val();
        new_tax.percent = $current.find('#tax_percent').val();
        
        let $targetDiv = $("#tax")[0];
        $last = $($targetDiv).find('.tax-row').last();
        $_content = $($last).clone();
        $($_content).find('input[name="tx_type"]').val(new_tax.type);
        $($_content).find('input[name="tx_percent"]').val(new_tax.percent);
        $($_content).css('display', 'block');
        $last.after($_content);
        tax_arr.push(new_tax);
    })
}

//Output Provider
function analyzeProvider() {
    let $tabs = $('.tab');
    let $providerTab = $tabs[5];
    
    var new_provider = {
        "type" : "",
        "name" : "",
        "b2b" : false,
        "acc_number" : "",
    };
    
    new_provider.type = $($providerTab).find('#provider_type').val();
    new_provider.name = $($providerTab).find('#provider_name').val();
    new_provider.b2b = $($providerTab).find("input[name='provider_b2b[]']:checked").val();
    new_provider.acc_number = $($providerTab).find('#provider_acc_number').val();
   
    let $targetDiv = $("#provider")[0];
   
    $($targetDiv).find('select[name="pr_type"]').val(new_provider.type);
    $($targetDiv).find('input[name="pr_name"]').val(new_provider.name);
    $($targetDiv).find('input[name="pr_accnumber"]').val(new_provider.acc_number);
    
    if(new_provider.b2b == 'yes')
    {
        $("#provider_b2b_yes").prop("checked", true);
        $("#provider_b2b_no").prop("checked", false);
    }
    else
    {
        $("#provider_b2b_yes").prop("checked", false);
        $("#provider_b2b_no").prop("checked", true);
    }
}

function cleanReport() {
    let $addressDiv = $("#address")[0];
    $($addressDiv).find('.address-row[style*="display: block;"]').remove();
    
    let $phoneDiv = $("#phone")[0];
    $($phoneDiv).find('.phone-row[style*="display: block;"]').remove();
    
    let $emailDiv = $("#email")[0];
    $($emailDiv).find('.email-row[style*="display: block;"]').remove();
    
    let $taxDiv = $("#tax")[0];
    $($taxDiv).find('.tax-row[style*="display: block;"]').remove();
    
    let $providerDiv = $("#provider")[0];
    $($providerDiv).find('.provider-row[style*="display: block;"]').remove();
    
    /*
    let $addressDiv = $("#address")[0];
    $($addressDiv).html(
        '<span class="row-title"> Address </span>' + 
        '<div class="address-row"></div>'
    );

    let $phoneDiv = $("#phone")[0];
    $($phoneDiv).html(
        '<span class="row-title"> Phone number </span>' + 
        '<div class="phone-row"></div>'
    );

    let $emailDiv = $("#email")[0];
    $($emailDiv).html(
        '<span class="row-title"> Email </span>' + 
        '<div class="email-row"></div>'
    );

    let $taxDiv = $("#tax")[0];
    $($taxDiv).html(
        '<span class="row-title"> Tax </span>' + 
        '<div class="tax-row"></div>'
    );

    let $providerDiv = $("#provider")[0];
    $($providerDiv).html(
        '<span class="row-title"> Provider </span>' + 
        '<div class="provider-row"></div>'
    );

    /**/
    address_arr = [];
    phone_arr = [];
    email_arr = [];
    tax_arr = [];
    provider_arr = [];
}

function analyzeReport(){
    let $tabs = $('.tab');
    let $branchTab = $tabs[0];
    cleanReport();
    analyzeBranch();
    analyzeAddress();
    analyzePhone();
    analyzeEmail();
    analyzeTax();
    analyzeProvider();
}

function showTab(number) {
    let $tabs = $('.tab');
    let $openTab = $($tabs[number]);
    let $prevBtn = $('#prevBtn');
    let $nextBtn = $('#nextBtn');
    let $submitBtn = $('#submitBtn');

    $openTab.css("display", "block");

    number == 0 ? $prevBtn.css("display", "none") : $prevBtn.css("display", "inline");
    number == ($tabs.length-1) ? $nextBtn.text("Submit") : $nextBtn.text("Next");
    if(number == ($tabs.length-1)) //if report page
    {
        $nextBtn.css("display", "none");
        $submitBtn.css("display", "inline");
        analyzeReport();
    }
    else{
        $nextBtn.css("display", "inline");
        $submitBtn.css("display", "none");
    }

    if(number == $tabs.length){
        $nextBtn.css("display", "none");
        $prevBtn.css("display", "none");
        $submitBtn.css("display", "none");
    }
    //number == ($tabs.length-1) ? $prevBtn.css('display', 'none') : $prevBtn.css('display', 'inline');
    number <= ($tabs.length - 1) ? $('.registration-successful').css('display', 'none') : $('.registration-successful').css('display', 'block');

    makeValidationAddress();
   
    fixStepIndicator(number);
}

function makeValidationAddress()
{
    $('#registerForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The username can only consist of alphabetical and number'
                    },
                    different: {
                        field: 'password',
                        message: 'The username and password cannot be the same as each other'
                    }
                }
            },

            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The email address is not a valid'
                    }
                }
            },

            branch_type: {
                feedbackIcons: 'false',
                validators: {
                    notEmpty: {
                        message: 'Required and cannot be empty'
                    }
                }
            },

            branch_timezone: {
                feedbackIcons: 'true',
                validators: {
                    notEmpty: {
                        message: 'Required and cannot be empty'
                    }
                }
            },

            branch_name: {
                feedbackIcons: 'true',
                validators: {
                    notEmpty: {
                        message: 'Required and cannot be empty'
                    }
                }
            },

            branch_radius: {
                feedbackIcons: 'true',
                validators: {
                    notEmpty: {
                        message: 'Required and cannot be empty'
                    }
                }
            },

            branch_time : {
                feedbackIcons: 'true',
                validators: {
                    notEmpty: {
                        message: 'Required and cannot be empty'
                    }
                }
            },

            'address_type[]': {
                feedbackIcons: 'false',
                validators: {
                    notEmpty: {
                        message: 'The address is required and cannot be empty'
                    }
                }
            },
            'address_city[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'The city is required and cannot be empty'
                    }
                }
            },

            'address_zip[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'The zip is required and could not be empty'
                    },
                    integer: {
                        message: 'The value is not an integer'
                    },
                }
            },
            
            'address_county[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'The county is required and could not be empty'
                    },
                }
            },

            'address_1[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'The Address is required and cannot be empty'
                    }
                }
            },
            'phone_type[]': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'required and cannot be empty'
                    },
                   
                }
            },
            'phone_number[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'The phone number type is required and cannot be empty'
                    },
                    integer: {
                        message: 'The value is not an integer'
                    },
                }
            },
            'email_type[]': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'required and cannot be empty'
                    },
                }
            },
            'email_address[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'Required field, cannot be empty'
                    }
                }
            },
            'tax_type[]': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Required field, cannot be empty'
                    }
                }
            },

            'tax_percent[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'Required field, cannot be empty'
                    },
                    integer: {
                        message: 'The value is not an integer'
                    },
                    between: {
                        min: 0,
                        max: 100,
                        message: 'Should be 0 - 100'
                    }
                }
            },
            'provider_type[]': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Required field, cannot be empty'
                    },
                }
            },
            
            'provider_name[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'Required field, cannot be empty'
                    },
                }
            },
            'provider_acc_number[]': {
                feedbackIcons: true,
                validators: {
                    notEmpty: {
                        message: 'Required field, cannot be empty'
                    },
                    integer: {
                        message: 'The value is number'
                    },
                },
            },
            'provider_b2b[]': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Required field, cannot be empty'
                    },
                },
            },
            'br_type': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'br_name': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'br_timezone': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'br_radius': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'br_timeformat': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            
            'add_1': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },

            'add_2': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            
            'add_city': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'add_county': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'add_zip': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                    integer:{
                        message: 'must be number!'
                    },
                },
            },
            'ph_type': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'ph_number': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'em_type': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'em_address': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'tx_type': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'tx_percent': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                    integer: {
                        message: 'Must be number!'
                    },
                    between: {
                        min: 0,
                        max: 100,
                        message: 'Should be 0 - 100'
                    }
                },
            },
            'pr_type': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'pr_name': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                },
            },
            'pr_accnumber': {
                feedbackIcons: false,
                validators: {
                    notEmpty: {
                        message: 'Invalid!'
                    },
                    integer: {
                        message: 'The value is not an integer'
                    },
                 
                },
            },
        }
    });
}

function fixStepIndicator(number) {
    $steps = $('.step');
    $currentStep = $($steps[number]);
    $steps.each(function (e) {
        $this = $(this);
        $this.removeClass('active');
    })
    $currentStep.addClass("active");
}

function onSubmitBtn(){
    // makeValidationAddress();
    if(!validateTab(currentTab))
    {
       return;
    }
    $curTab = $('.tab')[reportTab];
    $branchDiv = $($curTab).find('#branch');
    var br = {
        "type" : 'a',
        "name" : 'aaa',
        "timezone" : 1,
        "radius" : 1,
        "mulreg" : false,
        "noskill" : false,
        "timeformat" : '12',
    };
    br.type = $($branchDiv).find('select[name="br_type"]').val();
    br.name = $($branchDiv).find('input[name="br_name"]').val();
    br.timezone = $($branchDiv).find('select[name="br_timezone"]').val();
    br.radius = $($branchDiv).find('select[name="br_radius"]').val();
    br.timeformat = $($branchDiv).find('select[name="br_timeformat"]').val();
    br.mulreg = $($branchDiv).find('input[name="br_mulreg"]').is(':checked');
    br.noskill = $($branchDiv).find('input[name="br_noskill"]').is(':checked');
    br.timeformat = $($branchDiv).find("input[name='br_time']:checked").val();
    

    var address_arr = []
    $addressDiv = $($curTab).find("#address");
    $rows = $($addressDiv).find('.address-row[style*="display: block;"]')
    $rows.each(function(e) {
        let $curRow = $rows[e];
        var entry = {
            "type" : "",
            "city" : "",
            "county" : "",
            "zip" : "",
            "address1" : "",
            "address2" : "",
        };
        entry.type = $($curRow).find('select[name="add_type"]').val();
        entry.address1 = $($curRow).find('input[name="add_1"]').val(); 
        entry.address2 = $($curRow).find('input[name="add_2"]').val(); 
        entry.city = $($curRow).find('input[name="add_city"]').val();
        entry.county = $($curRow).find('input[name="add_county"]').val();
        entry.zip = $($curRow).find('input[name="add_zip"]').val();
        address_arr.push(entry);
    });

    var phone_arr = [];
    $phoneDiv =$($curTab).find('#phone');
    $rows = $($phoneDiv).find('.phone-row[style*="display: block;"]')
    $rows.each(function(e) {
        let $curRow = $rows[e];
        var entry = {
            "type" : "",
            "number" : "",
        };
        entry.type = $($curRow).find('select[name="ph_type"]').val();
        entry.number = $($curRow).find('input[name="ph_number"]').val();
        phone_arr.push(entry);
    });
    
    var email_arr = [];
    $emailDiv =$($curTab).find('#email');
    $rows = $($emailDiv).find('.email-row[style*="display: block;"]')
    $rows.each(function(e) {
        let $curRow = $rows[e];
        var entry = {
            "type" : "",
            "address" : "",
        };
        entry.type = $($curRow).find('select[name="em_type"]').val();
        entry.address = $($curRow).find('input[name="em_address"]').val();
        email_arr.push(entry);
    });
    
    var tax_arr = [];
    $taxDiv =$($curTab).find('#tax');
    $rows = $($taxDiv).find('.tax-row[style*="display: block;"]')
    $rows.each(function(e) {
        let $curRow = $rows[e];
        var entry = {
            "type" : "",
            "percent" : 0,
        };
        entry.type = $($curRow).find('input[name="tx_type"]').val();
        entry.percent = $($curRow).find('input[name="tx_percent"]').val();
        tax_arr.push(entry);
    });

    var provider_arr = [];
    $providerDiv =$($curTab).find('#provider');
    
    var entry = {
        "type" : "",
        "name" : 0,
        "b2b" : false,
        "acc_number" : "",
    };

    entry.type = $($providerDiv).find('select[name="pr_type[]"]').val();
    entry.name = $($providerDiv).find('select[name="pr_name[]"]').val();
    entry.acc_number = $($providerDiv).find('input[name="pr_accnumber"]').val();
    entry.b2b = $($providerDiv).find("input[name='pr_b2b[]']:checked").val();

    provider_arr.push(entry);
    
    updatedIds    =   $("#updatedIds").val();
    
    $postData = {
        "branch" : br,
        "address_arr" : address_arr,
        "email_arr" : email_arr,
        "phone_arr" : phone_arr,
        "tax_arr" : tax_arr,
        "provider_arr" : provider_arr,
        'updated_ids': updatedIds, 
    };

    console.log($postData);
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    $.ajax({
        url: "/add_branch",
        type: "post",
        data: $postData ,
        
        success: function (response) {
            // alert(response.message);
            if(response.result == 'success'){
                let $tabs = $('.tab');
                let $prevBtn = $('#prevBtn');
                let $nextBtn = $('#nextBtn');
                let $submitBtn = $('#submitBtn');

                $nextBtn.css("display", "none");
                $prevBtn.css("display", "none");
                $submitBtn.css("display", "none");
                $('.registration-successful').css('display', 'block');
                $(".tab").css('display', 'none');

                updatedIds  =   response.updated_ids;

                $("#updatedIds").val(updatedIds);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}

function hiddenSuccess()
{
    let $tabs = $('.tab');
    let $prevBtn = $('#prevBtn');
    let $nextBtn = $('#nextBtn');
    let $submitBtn = $('#submitBtn');

    $prevBtn.css("display", "block");
    $submitBtn.css("display", "block");
    $('.registration-successful').css('display', 'none');
    showTab(6);
    $("#logout-form").css("display", "block");
}

function nextPrev(number) {
    if(!validateTab(currentTab))
    {
        // return;
    }
    let $tabs = $('.tab');
    //   (number == 1 && !validateForm()) ? (return false) : "";
    if (number == 1 && !validateForm()) 
        return false;
    $($tabs[currentTab]).css("display", "none");
    currentTab = currentTab + number;
    if (currentTab >= $tabs.length) {
        $('#regForm').css('display', 'none');
        $('.registration-successful').css('display', 'block');
        return false;
    }
    showTab(currentTab);
}

function validateForm() {
    return true;
    let $tabs = $('.tab');
    let $currentTabInputs = $($tabs[currentTab].getElementsByTagName("input"));
    let i = 0;
    let valid = true;
    $currentTabInputs.each(function (e) {
        let $currentTabInput = $($currentTabInputs[e])
        if ($currentTabInput.val() == "") {
            $currentTabInput.addClass('invalid');
            valid = false;
        }
    })
    valid ? $($('.step')[currentTab]).addClass('finish') : false;
    return valid;
}

//address_tab = 1
function onAddAddress() {
    if(!validateTab(1))
    {
        return;
    } 
    let $tabs = $('.tab');
    let $curTab = $tabs[1];
    let $last_row = $($curTab).find(".address-row").last();
    let $cnt = $($curTab).find(".address-row").length+1;

    $new_row = $(addressForm).clone();
    $($new_row).find('span.row-title').text("Address" + $cnt);
    $last_row.after($new_row);

    $option   = $($curTab).find('[name="address_type[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
    $option   = $($curTab).find('[name="address_city[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
    $option   = $($curTab).find('[name="address_1[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
    $option   = $($curTab).find('[name="address_2[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
    $option   = $($curTab).find('[name="address_zip[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
    $option   = $($curTab).find('[name="address_county[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
}

function onDeleteAddress(){
    let $tabs = $('.tab');
    let $address_tab = $tabs[1];
    let $last_row = $($address_tab).find(".address-row").last();
    let $cnt = $($address_tab).find(".address-row").length;
    if($cnt <= 1)
    {
        alert('You need at least one!');
        return;
    }
    if (confirm('Are you sure to remove the address?')) {
        $($last_row).remove();
    } else {
        //alert('Why did you press cancel? You should have confirmed');
    }
    
}

function validateTab(tabIndex)
{
    // return true;
    $('#registerForm').bootstrapValidator('validate');
    let $tabs = $('.tab');
    let $address_tab = $tabs[tabIndex];
    $errorItems = $($address_tab).find('.has-error');
    if($errorItems.length > 0)
        return false;
    else 
        return true;
}
function validateSubmit()
{
    // return true;
    $('#registerForm').bootstrapValidator('validate');
    let $tabs = $('.tab');
    let $submitTab = $tabs[reportTab];
    $errorItems = $($submitTab).find('.help-block');
    if($errorItems.length > 0)
        return false;
    else 
        return true;
}

//phone_tab = 2
function onAddPhone() {
    if(!validateTab(2))
    {
        return;
    } 
    let $tabs = $('.tab');
    let $curTab = $tabs[2];
    let $last_row = $($curTab).find(".phone-row").last();
    let $cnt = $($curTab).find(".phone-row").length+1;

    $new_row = $(phoneForm).clone();
    $($new_row).find('span.row-title').text("Phone" + $cnt);
    $last_row.after($new_row);

    $option   = $($curTab).find('[name="phone_type[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
    $option   = $($curTab).find('[name="phone_number[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
}


function onDeletePhone(){
    let $tabs = $('.tab');
    let $curTab = $tabs[2];
    let $last_row = $($curTab).find(".phone-row").last();
    let $cnt = $($curTab).find(".phone-row").length;
    if($cnt <= 1)
    {
        alert('You need at least one!');
        return;
    }
    if (confirm('Are you sure to remove the address?')) {
        $($last_row).remove();
    } else {
        //alert('Why did you press cancel? You should have confirmed');
    }
    
}
//email_tab = 3
function onAddEmail() {
    if(!validateTab(3))
    {
        return;
    } 
    let $tabs = $('.tab');
    let $curTab = $tabs[3];
    let $last_row = $($curTab).find(".email-row").last();
    let $cnt = $($curTab).find(".email-row").length+1;

    $new_row = $(emailForm).clone();
    $($new_row).find('span.row-title').text("Email" + $cnt);
    $last_row.after($new_row);

    $option   = $($curTab).find('[name="email_type[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
    $option   = $($curTab).find('[name="email_address[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
}

function onDeleteEmail(){
    let $tabs = $('.tab');
    let $curTab = $tabs[3];
    let $last_row = $($curTab).find(".email-row").last();
    let $cnt = $($curTab).find(".email-row").length;
    if($cnt <= 1)
    {
        alert('You need at least one!');
        return;
    }
    if (confirm('Are you sure to remove the address?')) {
        $($last_row).remove();
    } else {
        //alert('Why did you press cancel? You should have confirmed');
    }
    
}

//tax_tab = 4
function onAddTax() {
    if(!validateTab(4)) 
    {
        return;
    } 
    let $tabs = $('.tab');
    let $curTab = $tabs[4];
    let $last_row = $($curTab).find(".tax-row").last();
    let $cnt = $($curTab).find(".tax-row").length+1;

    $new_row = $(taxForm).clone();
    $($new_row).find('span.row-title').text("Tax" + $cnt);
    $last_row.after($new_row);
    
    $option   = $($curTab).find('[name="tax_type[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);

    $option   = $($curTab).find('[name="tax_percent[]"]');
    $('#registerForm').bootstrapValidator('addField', $option);
}

function onDeleteTax(){
    let $tabs = $('.tab');
    let $curTab = $tabs[4];
    let $last_row = $($curTab).find(".tax-row").last();
    let $cnt = $($curTab).find(".tax-row").length;
    if($cnt <= 1)
    {
        alert('You need at least one!');
        return;
    }
    if (confirm('Are you sure to remove the address?')) {
        $($last_row).remove();
    } else {
        //alert('Why did you press cancel? You should have confirmed');
    }
    
}
