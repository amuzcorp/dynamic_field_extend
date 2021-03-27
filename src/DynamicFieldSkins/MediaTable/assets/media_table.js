

function media_popup(media_id) {
  var cnt = 0;

  XE.app('MediaLibrary').then(function (appMediaLibrary) {
    appMediaLibrary.open({
      listMode: 2,
      user: user,
      selected: function (mediaList) {
        $.each(mediaList, function () {

          var over_chk = $('.thumb_' + media_id).find("input." + mediaList[cnt]['file']['id']).val();

          if (over_chk == null) {
            var img_string = '<li>';
            img_string += '<input type="hidden" name="' + media_id + '_column[]" class="' + mediaList[cnt]['file']['id'] + '" value=' + mediaList[cnt]['file']['id'] + '>';
            img_string += '<div class="row"><div class="col-sm-3">';
            img_string += '<img width=100px height=100px src=' + mediaList[cnt]['file']['url'] + '>';
            img_string += '</div><div class="col-sm-9"><a href="#" class="pull-right" onclick="media_del(jQuery(this).parent().parent().parent()); return false"><i class="xi-close"></i></a>';
            img_string += '<h4>'+mediaList[cnt]['title']+'</h4>';
            img_string += '<h5>'+mediaList[cnt]['description']+'</h5>';
            img_string += '<p>'+mediaList[cnt]['caption']+'</p>';
            img_string += '</div></div>';
            img_string += '</li>';

            if(mediaList[cnt]['file']['url']) {
              $('.thumb_' + media_id).append(img_string);
            }

            cnt++;
          }
        })
        //setSort
        MediaSortable();
      }
    })
  })
}

function media_del(my_data) {
  my_data.remove();
}

function MediaSortable() {
  $(".media_meta_table").sortable({
    placeholder:"itemBoxHighlight"
  });
}
jQuery(document).ready(function($){
  MediaSortable();
});
