<?

$title_left_html = 'Custom Attributes';




// Determine if this is a host or a subnet we are dealing with
if (is_numeric($record['subnet_type_id'])) {
    $kind = 'subnets';
}
else {
    $kind = 'hosts';
}

list($status, $rows, $attributes) = db_get_records($onadb, 'custom_attributes', array('table_id_ref' => $record['id'], 'table_name_ref' => $kind), '');

// CUSTOM ATTRIBUTES LIST
$modbodyhtml .= <<<EOL
        <!-- CUSTOM ATTRIBUTES -->
        <table width=100% cellspacing="0" border="0" cellpadding="0" style="margin-bottom: 8px; margin-top: 0px;">
EOL;


if ($rows) {
    foreach ($attributes as $entry) {
        list($status, $rows, $ca_type) = ona_get_custom_attribute_record(array('id' => $entry['id']));
        foreach(array_keys($ca_type) as $key) { $ca_type[$key] = htmlentities($ca_type[$key], ENT_QUOTES); }

        $ca_type['value'] = truncate($ca_type['value'],20);
        $modbodyhtml .= <<<EOL
            <tr onMouseOver="this.className='row-highlight';"
                onMouseOut="this.className='row-normal';">

                <td align="left" nowrap="true" title="{$ca_type['notes']}">
                    {$ca_type['name']}&nbsp;&nbsp;
                </td>
                <td align="left" nowrap="true" style="border-left: 1px solid; border-left-color: #aaaaaa;padding-left: 3px;">
                    {$ca_type['value']}&nbsp;
                </td>
                <td align="right" nowrap="true">
                    <form id="form_custom_attribute_{$entry['id']}"
                        ><input type="hidden" name="id" value="{$entry['id']}"
                        ><input type="hidden" name="{$kind}_id" value="{$record['id']}"
                        ><input type="hidden" name="js" value="{$extravars['refresh']}"
                    ></form>
EOL;
        if (auth('advanced',$debug_val)) {
            $modbodyhtml .= <<<EOL
                    <a title="Edit Custom Attribute. ID: {$ca_type['id']}"
                        class="act"
                        onClick="xajax_window_submit('edit_custom_attribute', xajax.getFormValues('form_custom_attribute_{$entry['id']}'), 'editor');"
                    ><img src="{$images}/silk/page_edit.png" border="0"></a>

                    <a title="Delete Custom Attribute. ID: {$ca_type['id']}"
                        class="act"
                        onClick="var doit=confirm('Are you sure you want to delete this custom attribute?');
                                if (doit == true)
                                    xajax_window_submit('edit_custom_attribute', xajax.getFormValues('form_custom_attribute_{$entry['id']}'), 'delete');"
                    ><img src="{$images}/silk/delete.png" border="0"></a>
EOL;
        }
        $modbodyhtml .= <<<EOL
                </td>
            </tr>

EOL;
    }
}


if (auth('advanced',$debug_val)) {
    $modbodyhtml .= <<<EOL
            <tr>
                <td colspan="5" align="left" valign="middle" nowrap="true" class="act-box">

                    <form id="form_custom_attribute_add_{$record['id']}"
                        ><input type="hidden" name="{$kind}_id" value="{$record['id']}"
                        ><input type="hidden" name="js" value="{$extravars['refresh']}"
                    ></form>

                    <a title="Add Custom Attribute"
                        class="act"
                        onClick="xajax_window_submit('edit_custom_attribute', xajax.getFormValues('form_custom_attribute_add_{$record['id']}'), 'editor');"
                    ><img src="{$images}/silk/page_add.png" border="0"></a>&nbsp;

                    <a title="Add Custom Attribute"
                        class="act"
                        onClick="xajax_window_submit('edit_custom_attribute', xajax.getFormValues('form_custom_attribute_add_{$record['id']}'), 'editor');"
                    >Add Custom Attribute</a>&nbsp;
                </td>
            </tr>
EOL;
}

$modbodyhtml .= "</table>";

// END CUSTOM ATTRIBUTES LIST



?>