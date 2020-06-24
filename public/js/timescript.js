$(function() {
    var d = new Date();
    var time = d.getHours();
    if (( time < 9 || time >= 15 /*true*/) && role == 5) {
        $('.profile-time-func').detach();
        $('.text-reg-func').detach();
    } else {
        $('.profile-time-func').css('display', 'block');
        $('.text-reg-func').css('disply', 'block');
    }
});