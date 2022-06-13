"use strict";
function Admin() {
    var self = this;
    this.init = function () {
        self.ScriptLicense();
        self.Item();
        self.Users();
        self.FileManager();
        self.Provider();
        self.Services();
};

    this.Services = function () {
        // Check post type
        var pathGetProviderServicesURL  = PATH + 'admin/services/provider_services/';
        $(document).on("change", "select[name=add_type]", function(){
            var element = $(this),
                mode    = element.val();
            if(mode == 'api'){
            $('.api-mode').removeClass('d-none');
            $('.manual-mode').addClass('d-none');
            }else{
            $('.manual-mode').removeClass('d-none');
            $('.api-mode').addClass('d-none');

            // Refill option
            $(".refill-type-option").html('<option value="0"> Manual </option>');
            $("#refill-option").prop('checked', false);
            $("#refill-from").removeClass('show');
            }
        });
        
        /*----------  Get Services list from API  ----------*/
        $(document).on("change", ".ajaxGetServicesFromAPI" , function(){
            event.preventDefault();
            $('.provider-services-list').removeClass('d-none');
            $('.provider-services-list .dimmer').addClass('active');
            var element  = $(this),
                id       = element.val();
            if (id == "" || id == 0) return;
            var data       = $.param({token:token, provider_id:id});
            $.post(pathGetProviderServicesURL, data, function(_result){
            setTimeout(function () {
                $(".crud-service-form input[name=original_price]").val('');
                $(".crud-service-form input[name=api_service_type]").val('');
                $(".crud-service-form input[name=api_service_dripfeed]").val('');
                $(".crud-service-form input[name=api_service_refill]").val('');
                $(".crud-service-form input[name=api_service_id]").val('');

                // Refill Option
                $(".refill-type-option").html('<option value="0"> Manual </option>');
                $("#refill-option").prop('checked', false);
                $("#refill-from").removeClass('show');

                $('.provider-services-list .dimmer').removeClass('active');
                $(".provider-services-list select").html(_result);
            }, 100);
            });
        }) 

        // Select Provider Service
        $(document).on("change", ".ajaxGetServiceDetail", function(){
            $(".crud-service-form input[name=original_price]").val('');
            $(".crud-service-form input[name=min]").val('');
            $(".crud-service-form input[name=max]").val('');
            var element    = $('option:selected', this),
                _name      = element.attr('data-name'),
                _min       = element.attr('data-min'),
                _max       = element.attr("data-max"),
                _rate      = element.attr("data-rate"),
                _type      = element.attr("data-type"),
                _dripfeed  = element.attr("data-dripfeed"),
                _refill    = element.attr("data-refill");
            $(".crud-service-form input[name=original_price]").val(_rate);
            $(".crud-service-form input[name=api_service_type]").val(_type);
            $(".crud-service-form input[name=api_service_dripfeed]").val(_dripfeed);
            $(".crud-service-form input[name=api_service_refill]").val(_refill);

            // Refill Option
            $(".refill-type-option").html('<option value="0"> Manual </option>');
            $("#refill-option").prop('checked', false);
            $("#refill-from").removeClass('show');
            if (_refill == 1) {
                $(".refill-type-option").append('<option value="1"> Provider </option>');
            }
            $(".crud-service-form input[name=min]").val(_min);
            $(".crud-service-form input[name=max]").val(_max);
            $(".crud-service-form input[name=price]").val(_rate);
        })
    }

    this.Provider = function () {
        // Update balance
        $(document).on("click", ".ajaxUpdateApiProvider", function () {
            pageOverlay.show();
            event.preventDefault();
            var element = $(this),
                url = element.attr("href"),
                redirect_url = element.data("redirect"),
                data = $.param({ token: token });
            callPostAjax(element, url, data, '');
        })
    }

    this.Users = function () {
        $(document).on("click", ".btnEditCustomRate", function () {
            var element = $(this),
                url = element.data("action");
            $('#customRate').load(url, function () {
                $('#customRate').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#customRate').modal('show');
            });
            return false;
        });
    }

    this.ScriptLicense = function () {
        $(document).on("click", ".ajaxUpgradeVersion", function () {
            pageOverlay.show();
            event.preventDefault();
            var element = $(this),
                url = element.attr("href"),
                data = $.param({ token: token });
            callPostAjax(element, url, data, '');
        })
    }

    // Upload media on Settings page
    this.FileManager = function () {
        var url = PATH + "upload_files";
        $(document).on('click', '.settings_fileupload', function () {
            var element = $(this);
            var _closest_div = element.closest('div');
            $('.settings .settings_fileupload').fileupload({
                url: url,
                formData: { token: token },
                dataType: 'json',
                done: function (e, data) {
                    if (data.result.status == "success") {
                        var _img_link = data.result.link;
                        _closest_div.children('input').val(_img_link);
                    }
                },
            });
        });
    }

    this.Item = function () {
        // check all
        $(document).on('click', '.check-all', function(){
            var element      = $(this),
               _checkName = element.data('name');
            $('.' + _checkName + '').prop('checked', this.checked);
        })

        // ajaxChangeCurrencyCode - Payment update form
        $(document).on("change", ".ajaxChangeCurrencyCode", function () {
            var element = $(this),
                currency_code = element.val();
            $(".new-currency-code").html(currency_code);
        });

        // ajaxToggleItemStatus
        $(document).on("click", ".ajaxToggleItemStatus", function () {
            var element = $(this),
                id = element.data('id'),
                url = element.data('action') + id;
            var status = 0;
            if (element.is(":checked")) status = 1;
            var data = $.param({ token: token, status: status });
            console.log(data);
            callPostAjax(element, url, data, 'status');
        });

        // ajaxChangeSort
        $(document).on("change", ".ajaxChangeSort", function () {
            var element = $(this),
                id = element.data('id'),
                url = element.data('url') + id,
                sort = element.val();
            var data = $.param({ token: token, sort: sort });
            callPostAjax(element, url, data, 'sort');
        });

        // callback Delete item
        $(document).on("click", ".ajaxDeleteItem", function () {
            event.preventDefault();
            var element = $(this),
                confirm_message = element.data('confirm_ms');
            if (!confirm_notice(confirm_message)) {
                return;
            }
            var url = element.attr("href"),
                data = $.param({ token: token });
            callPostAjax(element, url, data, 'delete-item');
        });

        $(document).on("click", ".ajaxActionOptions", function () {
            event.preventDefault();
            var element = $(this),
                type = element.data("type");
            console.log(type);
            
            if ((type == 'delete' || type == 'all_deactive' || type == 'clear_all' || type == 'empty')) {
                if (!confirm_notice('deleteItems')) {
                    return;
                }
            }
            var url = element.attr("href");
            var selected_ids = [];
            $(".check-item:checked").each(function () {
                selected_ids.push($(this).val());
            });
            if (selected_ids.length <= 0 && type != 'empty' ) {
                alert("Please choose at least one item");
            } else {
                selected_ids = selected_ids.join(",");
                var data = 'ids=' + selected_ids + '&' + $.param({ token: token });
                pageOverlay.show();
                callPostAjax(element, url, data, '');
            }
        })

        // callback ajaxChange Sort By
        $(document).on("change", ".ajaxListServicesSortByCateogry", function () {
            pageOverlay.show();
            event.preventDefault();
            var element = $(this),
                id = element.val();

            if (id == "") {
                pageOverlay.hide();
                return false;
            }
            var pathname = element.data("url") + "?" + "sort_by=" + id;
            window.location.href = pathname;
        })

        // callback ajaxChange
        $(document).on("change", ".ajaxGetServicesChangeByProvider", function () {
            event.preventDefault();
            pageOverlay.show();
            var element = $(this),
                id = element.val();
            if (id == 0) {
                pageOverlay.hide();
                return false;
            }
            var url = element.data("url") + id;
            var data = $.param({ token: token });
            callPostAjax(element, url, data, 'get-result-html');
        })
    }
}

Admin = new Admin();
$(function () {
    Admin.init();
});

