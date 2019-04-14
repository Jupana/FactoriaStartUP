import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router'
//php bin/console fos:js-routing:dump --format=json --target=assets/js/js_routes.json   -- Liviu,Nico you have to run this command in order to get all the paths into json
import Routes from './js_routes.json'
Routing.setRoutingData(Routes)
const $ = require('jquery');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
require('bootstrap/js/dist/tooltip');
require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

    /*==================================================================
    [ Validate LOGIN ]*/

    (function ($) {
        "use strict";
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).removeClass('alert-validate');
    }

    /* <!-- START Modal Form Script*/
    //Profil user
        $('.add-profile').click(function () {
            let url = Routing.generate('addPerfilUpdate')
            let formProfileUser = document.getElementById('profile_user');
            formProfileUser.addEventListener('submit', function (event) {
                // XXX: make a post ajax request

                event.preventDefault()
                new Promise(function (resolve, reject) {
                    let xhr = new XMLHttpRequest()
                    let formData = new FormData(formProfileUser)
                    // third argument specifies if it's an async request or a sync
                    console.log(xhr)
                    xhr.addEventListener('load', function () {
                        if (this.readyState === 4) {
                            if (this.status === 200) {
                                resolve(JSON.parse(this.response))
                            } else {
                                reject(this.status)
                            }
                        }
                    })
                    xhr.open("POST", url)
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')

                    xhr.send(formData)
                }) // end of the promise
                    .then((data) => {
                        window.location.replace('/profiles')
                    })
                    .catch((error) => {
                        console.error(error)
                    })
            })
        })   

    /* FIN Modal Form Script -->*/

})(jQuery);    
    
   