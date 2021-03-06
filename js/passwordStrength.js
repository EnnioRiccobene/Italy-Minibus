$(document).ready(function() {
    $('#pwd').keyup(function() {
        $('#result').html(checkStrength($('#pwd').val()))
    })
    function checkStrength(password) {
        var strength = 0
        if (password.length < 2) {//il valore ottimalesarebbe 6
            $('#result').removeClass()
            $('#result').addClass('short')
            return 'Troppo breve'
        }
        if (password.length > 1) strength += 1//il valore ottimale sarebbe 7
        // If password contains both lower and uppercase characters, increase strength value.
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
        // If it has numbers and characters, increase strength value.
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
        // If it has one special character, increase strength value.
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        // If it has two special characters, increase strength value.
        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        // Calculated strength value, we can return messages
        // If value is less than 2
        if (strength < 2) {
            $('#result').removeClass()
            $('#result').addClass('weak')
            return 'Debole'
        } else if (strength == 2) {
            $('#result').removeClass()
            $('#result').addClass('good')
            return 'Media'
        } else {
            $('#result').removeClass()
            $('#result').addClass('strong')
            return 'Forte'
        }
    }
});