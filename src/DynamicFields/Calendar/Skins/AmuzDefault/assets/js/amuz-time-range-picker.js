$(document).ready(function() {
  setTimeout(function(){
    $('.amuz-time-range-picker').timepicker({
      timeFormat: 'HH:mm',
      interval: 10,
      minTime: '00:00',
      maxTime: '23:50',
      defaultTime: '09:00',
      startTime: '09:00',
      dynamic: false,
      dropdown: true,
      scrollbar: true,
      change: function(time) {
      }
    });
  }, 2000);
});
