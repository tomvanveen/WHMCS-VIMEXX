<h3>{$LANG.domaincontactinfo}</h3>

{include file="$template/includes/alert.tpl" type="info" msg=$LANG.whoisContactWarning}

{if $successful}
    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=true}
{/if}

{if $hasError}
    {include file="$template/includes/alert.tpl" type="error" msg=$errorMsg textcenter=true}
{/if}

{if $hasJob}
    {include file="$template/includes/alert.tpl" type="error" msg=$jobMsg textcenter=true}
{/if}

<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails&id={$domainid}&modop=custom&a=ContactApply">
    <input type="hidden" name="domain" value="{$domain}" />
    <input type="hidden" name="domainid" value="{$domainid}" />
    <input type="hidden" name="id" value="{$domainid}" />
    <input type="hidden" name="modop" value="custom" />
    <input type="hidden" name="a" value="ContactApply" />
    <input type="hidden" name="domainSld" value="{$domainSld}" />
    <input type="hidden" name="domainTld" value="{$domainTld}" />
    <input type="hidden" name="customAction" value="{$customAction}" />

    <div class="form-group">
        <label>Registrant</label>
        <select name="contact_registrant" class="form-control">
            <option value="">Selecteer een contact...</option>
            {foreach key=num item=contact from=$contacts}
                <option value="{$contact.id}" {if in_array('registrant', $contact.current)} selected="true" {/if}>{$contact.firstname} {$contact.lastname}</option>
            {/foreach}
        </select>
    </div>

    <div class="form-group">
        <label>Admin</label>
        <select name="contact_admin" class="form-control">
            <option value="">Selecteer een contact...</option>
            {foreach key=num item=contact from=$contacts}
                <option value="{$contact.id}" {if in_array('admin', $contact.current)} selected="true" {/if}>{$contact.firstname} {$contact.lastname}</option>
            {/foreach}
        </select>
    </div>

    <div class="form-group">
        <label>Billing</label>
        <select name="contact_billing" class="form-control">
            <option value="">Selecteer een contact...</option>
            {foreach key=num item=contact from=$contacts}
                <option value="{$contact.id}" {if in_array('billing', $contact.current)} selected="true" {/if}>{$contact.firstname} {$contact.lastname}</option>
            {/foreach}
        </select>
    </div>

    <div class="form-group">
        <label>Technical</label>
        <select name="contact_technical" class="form-control">
            <option value="">Selecteer een contact...</option>
            {foreach key=num item=contact from=$contacts}
                <option value="{$contact.id}" {if in_array('tech', $contact.current)} selected="true" {/if}>{$contact.firstname} {$contact.lastname}</option>
            {/foreach}
        </select>
    </div>

    <div class="form-group">
        <label>Technical 2</label>
        <select name="contact_technical2" class="form-control">
            <option value="">Selecteer een contact...</option>
            {foreach key=num item=contact from=$contacts}
                <option value="{$contact.id}" {if in_array('tech2', $contact.current)} selected="true" {/if}>{$contact.firstname} {$contact.lastname}</option>
            {/foreach}
        </select>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">
                <input type="submit" value="Save Changes" class="btn btn-primary">
                <input type="reset" value="Cancel Changes" class="btn btn-default">
            </p>
        </div>
    </div>
</form>

<br />
<br />