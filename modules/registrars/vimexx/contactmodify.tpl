<h3>{$LANG.domaincontactinfo}</h3>

{include file="$template/includes/alert.tpl" type="info" msg=$LANG.whoisContactWarning}

{if $successful}
    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=true}
{/if}

{if $hasError}
    {include file="$template/includes/alert.tpl" type="error" msg=$errorMsg textcenter=true}
{/if}
<br />
<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails&id={$domainid}&modop=custom&a=ContactModify">
    <input type="hidden" name="domain" value="{$domain}" />
    <input type="hidden" name="id" value="{$domainid}" />
    <input type="hidden" name="domainid" value="{$domainid}" />
    <input type="hidden" name="modop" value="custom" />
    <input type="hidden" name="a" value="ContactModify" />
    <input type="hidden" name="domainSld" value="{$domainSld}" />
    <input type="hidden" name="domainTld" value="{$domainTld}" />
    <input type="hidden" name="customAction" value="{$customAction}" />

    <div class="form-group">
        <label>Selecteer een contact</label>
        <select name="contact" onchange="doChangeContact(this)" class="form-control">
            <option value="">Selecteer een contact...</option>
            {foreach key=num item=contact from=$contacts}
                <option value="{$contact.id}">{$contact.firstname} {$contact.lastname}</option>
            {/foreach}
        </select>
    </div>

    <hr />
    <input type="hidden" name="contact_id" value="" class="form-control">

    <div class="form-group">
        <label>First Name <em class="required">*</em></label>
        <input type="text" name="firstname" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>Last Name <em class="required">*</em></label>
        <input type="text" name="lastname" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>Company Name</label>
        <input type="text" name="company" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>Email Address <em class="required">*</em></label>
        <input type="text" name="email" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>Street</label>
        <input type="text" name="street" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>Housenumber</label>
        <input type="text" name="housenumber" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>City</label>
        <input type="text" name="city" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>Zipcode</label>
        <input type="text" name="zipcode" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>Country</label>
        <select name="country" class="form-control">
            <option value="">Selecteer een country...</option>
            {foreach key=countryCode item=countryName from=$countries}
                <option value="{$countryCode}">{$countryName}</option>
            {/foreach}
        </select>
    </div>
    <div class="form-group">
        <label>Phone Number</label>
        <input type="text" name="phone" value="" class="form-control">
    </div>
    <div class="form-group">
        <label>Fax Number</label>
        <input type="text" name="fax" value="" class="form-control">
    </div>

    <div class="additional-fields"></div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">
                <input type="submit" value="Save Changes" class="btn btn-primary">
                <input type="reset" value="Cancel Changes" class="btn btn-default">
            </p>
        </div>
    </div>
</form>

<script type="text/javascript">

    var contacts = JSON.parse('{$contactsJson}');

    var doChangeContact = function(select) {
        var contactId = $('option:selected', select).val();

        $.each(contacts, function(key, contact) {
            if (contact.id == contactId) {
                $('.additional-fields').html('');

                $('input[name=contact_id]').val(contactId);
                $('input[name=firstname]').val(contact.firstname);
                $('input[name=lastname]').val(contact.lastname);
                $('input[name=company]').val(contact.company);
                $('input[name=email]').val(contact.email);
                $('input[name=street]').val(contact.street);
                $('input[name=housenumber]').val(contact.housenumber);
                $('input[name=city]').val(contact.city);
                $('input[name=zipcode]').val(contact.zipcode);
                $('select[name=country]').val(contact.country);
                $('input[name=phone]').val(contact.phone);
                $('input[name=fax]').val(contact.fax);

                if (typeof contact.extra_options != 'undefined') {
                    $.each(contact.extra_options, function(key, options) {
                        var extraInfo = $('<div />');

                        if (options.has_required_options || (options.has_required_company_options && contact.is_company)) {
                            var p = $('<em />');
                                p.addClass('requirements');

                            var label = $('<label />');
                                label.addClass('text-danger');
                                label.addClass('float-left');
                                label.html('Required:&nbsp;');

                            p.append(label);

                            $.each(options.required_options, function(key, optionValue) {
                                p.append(optionValue + ', ');
                            });

                            if (contact.is_company) {
                                $.each(options.required_company_options, function(key, optionValue) {
                                    p.append(optionValue + ', ');
                                });
                            }

                            extraInfo.append(p);
                        }

                        if (options.has_optional_options) {
                            var p = $('<em />');
                                p.addClass('requirements');

                            var label = $('<label />');
                                label.addClass('text-info');
                                label.addClass('float-left');
                                label.html('Optional:&nbsp;');

                            p.append(label);

                            $.each(options.optional_options, function(key, optionValue) {
                                p.append(optionValue + ', ');
                            });

                            extraInfo.append(p);
                        }

                        var formControl = buildControl(options.name, 'extra_options[' + key + ']', options.type, options.value, extraInfo);

                        $('.additional-fields').append(formControl);
                    });
                }
            }
        });
    }

    var buildControl = function(text, name, type, value, extra) {
        if (type == 'country') {
            var selectCountryHolder = $('select[name=country]').parent();
            var selectCountryHolderClone = selectCountryHolder.clone();

            $('select[name=country]', selectCountryHolderClone).attr('name', name);
            $('select[name="' + name + '"]', selectCountryHolderClone).find('option[value="' + value + '"]').attr("selected", true);

            $('label', selectCountryHolderClone).html(text);

            return selectCountryHolderClone;
        }

        var div = $('<div />');
            div.addClass('form-group');

        var label = $('<label />');
            label.html(text);

        var input = $('<input />');
            input.attr('name', name);
            input.addClass('form-control');
            input.val(value);

        switch (type) {
            case 'string':
                input.attr('type', 'text');
                break;

            case 'number':
                input.attr('number', 'text');
                break;

            case 'date':
                input.attr('date', 'text');
                break;
        }

        div.append(label);
        div.append(input);
        div.append(extra);

        return div;
    };

</script>