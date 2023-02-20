// const audio = new Audio("docs/mario.mp3");
// const buttons = document.querySelectorAll("#marial");

// buttons.forEach(button => {
//   button.addEventListener("click", () => {
//     audio.play();
//   });
// });







const marial = new Audio("docs/marial.mp3");

$ ("#marial").click (function (){

marial.play();

}); 


const mariol = new Audio("docs/mariol.mp3");

$ ("#mariol").click (function (){

mariol.play();

}); 









$(function () {



    $('#contact-form').validator();



    $('#contact-form').on('submit', function (e) {

        if (!e.isDefaultPrevented()) {

            var url = "contact.php";



            $.ajax({

                type: "POST",

                url: url,

                data: $(this).serialize(),

                success: function (data)

                {

                    var messageAlert = 'alert-' + data.type;

                    var messageText = data.message;



                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';

                    if (messageAlert && messageText) {

                        $('#contact-form').find('.messages').html(alertBox);

                        $('#contact-form')[0].reset();

                        grecaptcha.reset();

                    }

                }

            });

            return false;

        }

    })

});