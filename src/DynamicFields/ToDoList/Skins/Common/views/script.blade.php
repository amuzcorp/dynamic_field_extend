<script type="text/javascript">
    function add_TO_DO_List(config_id) {
        var list_count = +$('input[name='+config_id+'_count]').val();
        var str = `
        <tr>
            <td><input class="form-control" type="text" name="${config_id}_title[]" value="" onchange="setToDOListColumn('${config_id}')" /></td>
            <td><input type="checkbox" class="TO_DO_list_checked" name="${config_id}_check[]" onchange="setToDOListColumn('${config_id}')"/></td>
            <td><a class="btn btn-danger btn-sm config_list_remove text-white">제거</a></td>
        </tr>
        `;
        $("#" + config_id + "_TO_DO_List").append(str);
        $('input[name='+config_id+'_count]').val((list_count+1));
        setToDOListColumn(config_id);
    }
    $(document).on('click', '.config_list_remove', function(){
        var parentTag = $(this).closest("tr");
        parentTag.remove();
    });
    function setToDOListColumn(config_id) {
        var title_list = document.getElementsByName(config_id + "_title[]");
        var title_check = document.getElementsByName(config_id + "_check[]");

        var list_column = [];
        for(let i = 0; i < title_list.length; i++) {
            list_column.push({
                'title' : title_list[i].value,
                'checked' : title_check[i].checked
            });
        }
        $('input[name=' + config_id + '_columns]').val(JSON.stringify(list_column));
    }
</script>
