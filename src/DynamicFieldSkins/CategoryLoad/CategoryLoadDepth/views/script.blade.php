<script type="text/javascript">
    function getChildTaxonomyItem(name, title, taxo_id) {
        XE.ajax({
            url: '{{route('dyFac.child.taxonomies')}}',
            method: 'get',
            data: {
                taxo_id: taxo_id
            },
            cache: false,
            success: function (data) {
                var response = data.taxonomies;
                var sub_item_count = +$('input[name=' + name + '_sub_item_count]').val();
                var str = '';
                if(response.length !== 0) {
                    str = ` <div id="${name}_${sub_item_count}_form"><label>${title}</label>
                            <div class="xe-dropdown __xe-dropdown-form">
                                <select class="form-control" name="${name}_select_${sub_item_count}" onchange="selectTaxonomy('${name}', this, 'sub', ${sub_item_count + 1})">
                                   <option value="0_0">${title} 카테고리를 선택해주세요</option>`;
                    var child = 0;
                    for(let i = 0; i < response.length; i++) {
                        if(response[i].child === true) {
                            child = 1;
                        } else {
                            child = 0;
                        }
                        str += `<option value="${response[i].id}_${child}">${response[i].word}</option>`;
                    }
                    str += `</div></select></div>`;

                    $("#"+name+"_depth_sub_categories").append(str);
                }
            }
        });
    }

    function selectTaxonomy(name, target, type, index) {
        var value = +target.value.split("_")[0];
        var child = +target.value.split("_")[1];
        var selected_text = target[target.selectedIndex].text;

        let new_count = 0;

        if(document.getElementById(name+"_input")) {
            document.getElementById(name+"_input").value = value;
        } else {
            var count = +$('input[name=' + name + '_sub_item_count]').val();
            if(type === 'first'){
                document.getElementById(name+"_category_selected").innerHTML = '';
                document.getElementById(name+"_depth_sub_categories").innerHTML = '';
                if(value !== 0) {
                    $('input[name='+name + '_item_id]').val(JSON.stringify([value]));
                    $('input[name=' + name + '_sub_item_count]').val(1);
                } else {
                    $('input[name='+name + '_item_id]').val("[]");
                    $('input[name=' + name + '_sub_item_count]').val(0);
                }
            } else {
                var remove_count = 0;
                for(let i = 0; i < index + 1; i++) {
                    if(i > (index - 1)) {
                        if(document.getElementById(name + '_' + i + '_form')) {
                            $("#" + name + '_' + i + '_form').remove();
                            remove_count++;
                        }
                    }
                }
                new_count = count - remove_count;
                $('input[name=' + name + '_sub_item_count]').val( new_count );
            }

            if(type !== 'first') {
                var selected_value = 0;
                var selected_ids = [];
                for(let i = 0; i < count + 1; i++) {
                    if($('select[name='+name+'_select_'+i+']').length !== 0) {
                        selected_value = +$('select[name=' + name + '_select_' + i + ']').val().split("_")[0];
                        selected_ids.push(selected_value);
                    }
                }
                $('input[name='+name + '_item_id]').val(JSON.stringify(selected_ids));
            }

            if(value !== 0) {
                if (child === 1) {
                    count = (+$('input[name=' + name + '_sub_item_count]').val()) + 1;
                    $('input[name=' + name + '_sub_item_count]').val(count);

                    getChildTaxonomyItem(name, selected_text, value)
                }
            }

        }
    }
</script>
