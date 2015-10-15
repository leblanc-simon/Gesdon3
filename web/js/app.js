var $document = $(document);

function getContributorFromEmail(email, success_callback, error_callback)
{
    $.ajax({
        url: urls.api.contributor.get_by_email.replace(replace_parameter, email),
        type: 'GET',
        cache: false,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (success_callback) {
                success_callback(data);
            }
        },
        error: function () {
            if (error_callback) {
                error_callback();
            }
        }
    });
}

function getContributorLastAddressFromEmail(email, success_callback, error_callback)
{
    $.ajax({
        url: urls.api.contributor.last_address_by_email.replace(replace_parameter, email),
        type: 'GET',
        cache: false,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (success_callback) {
                success_callback(data);
            }
        },
        error: function () {
            if (error_callback) {
                error_callback();
            }
        }
    });
}

function addListenersForNewDonation()
{
    function replaceFormValue(data, prefix)
    {
        var $item, key;
        for (key in data) {
            $item = $(prefix + key);
            if ($item.length === 0) {
                continue;
            }

            $item.val(data[key]);
        }
    }

    $document
        .on('change', '#donation_contributor_email', function () {
            var value = $(this).val();
            getContributorFromEmail(
                value,
                function (data) {
                    replaceFormValue(data, '#donation_contributor_');
                }
            );

            getContributorLastAddressFromEmail(
                value,
                function (data) {
                    replaceFormValue(data, '#donation_contributor_single_address_');
                }
            )
        })
    ;
}

$document.ready(function () {
    "use strict";

    addListenersForNewDonation();
});