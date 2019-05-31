import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router'
/* Liviu NICO
php bin/console fos:js-routing:debug To see all the routs from FOS
php bin/console fos:js-routing:dump --format=json --target=assets/js/js_routes.json   -- Liviu,Nico you have to run this command in order to get all the paths into json
*/

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

    /* START FILTER PROYECTS*/
     
     $('.filter-proyects').click(function(){
        var sector = $( "select#select-sector" ).val();
        var km =$(".proyect-km").val();
        var lat = 0;
        var long = 0;
        var urlProyectFilter='';        
        let notBlocked= false;
      
        sector = isNaN(sector) ? 0:sector;

        if(km != ''){
            if (navigator.geolocation) {
                let notBlocked= true;
                navigator.geolocation.getCurrentPosition(function(position) {
                   let lat = position.coords.latitude ? position.coords.latitude : lat
                   let long = position.coords.longitude ? position.coords.longitude :long
                   urlProyectFilter = Routing.generate('proyectos_filter',{sector:sector,km:km,lat:lat,long:long})
                   window.location.replace(urlProyectFilter)               
                });
              } else {
                // Browser doesn't support Geolocation
                console.log("Para utilizar el filtro de distancia necesitamos que permitas tu localización ");       
              }
        }else{
            km=0;
            urlProyectFilter = Routing.generate('proyectos_filter',{sector:sector,km:km,lat:lat,long:long})
            window.location.replace(urlProyectFilter)  
        }
    })

    /*Fin FILTER PROYECTS*/

    /* START FILTER PROFILES*/
     
    $('.filter-profiles').click(function(){
        var profiles = $( "select#select-profiles" ).val();
        var km =$(".proyect-km").val();
        var lat = 0;
        var long = 0;
        var urlProyectFilter='';        
        profiles = isNaN(profiles) ? 0:profiles;
        console.log(km);
      
        if(km != ''){
            if (navigator.geolocation) {
               
                navigator.geolocation.getCurrentPosition(function(position) {
                   let lat = position.coords.latitude ? position.coords.latitude : lat
                   let long = position.coords.longitude ? position.coords.longitude :long
                   urlProyectFilter = Routing.generate('profiles_filter',{profiles:profiles,km:km,lat:lat,long:long})
                   window.location.replace(urlProyectFilter)               
                });
              } else {
                // Browser doesn't support Geolocation
                console.log("Para utilizar el filtro de distancia necesitamos que permitas tu localización ");       
              }
        }else{
            km=0;
            urlProyectFilter = Routing.generate('profiles_filter',{profiles:profiles,km:km,lat:lat,long:long})
            window.location.replace(urlProyectFilter)  
        }
    })

    /*Fin FILTER PROFILES*/
   
    /* <!-- START Modal Form Script*/
   
    /*<!--START AddProfil user */

  

        $('.add-profil').click(function () {
            let urlAddProfil = Routing.generate('addProfil');
            $.get(urlAddProfil, function(data){
                $('.modal-content').html(data);
                let formAddProfil = document.getElementById('profile_user');
                formAddProfil.addEventListener('submit', function (event) {    
                        // XXX: make a post ajax request
                        event.preventDefault()
                            let xhr = new XMLHttpRequest()
                            let formData = new FormData(formAddProfil)
                            xhr.open("POST", urlAddProfil)
                            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
                            xhr.send(formData)
                            xhr.onload = function () {
                                window.location.replace('/datos_profesionales')
                            };
                    }) //FIN SUBMIT EVENT
            })
        })
    /* FIN AddProfil user --!> */
    
    /* <!-- START PASSING DATA TO MODAL for the Update User Profile */
    $('.select_perfil').click(function (){
        var profilId= $(this).data("id");
        var profil=$(this).data("profil");
        var sector =$(this).data("sector");
        
        //Remove selected first ToDo
        $("#profile_user_profil option").prop("selected", false);
        $("#profile_user_sector option").prop("selected", false)
        
        $("#profile_user_profil option:contains(" + profil +")").attr("selected", true);
        $("#profile_user_sector option:contains(" + sector +")").attr("selected", true);
        

        let url = Routing.generate('editProfileUser',{id:profilId})
        $.get(url, function (data) {
            $(".modal-content").html(data);
                //Liviu, Nico we send the data here avter we bind the DATA to Modal Content

                 /*Remove selected first ToDo
                 This is hack into html Liviu, Nico you have to fixed into modal/Addperfil.html {value:'perfil.sector'} no is not working
                 */
                $("#profile_user_profil option").prop("selected", false);
                $("#profile_user_sector option").prop("selected", false)
                
                $("#profile_user_profil option:contains(" + profil +")").attr("selected", true);
                $("#profile_user_sector option:contains(" + sector +")").attr("selected", true);


                let formProfileUserUpdate = document.getElementById('profile_user');
                formProfileUserUpdate.addEventListener('submit', function (event) {
            
                    let urlUpdate = Routing.generate('editProfilUserUpdate',{id:profilId})
                    
                        // XXX: make a post ajax request
                        event.preventDefault()
                        new Promise(function (resolve, reject) {
                            let xhr = new XMLHttpRequest()
                            let formData = new FormData(formProfileUserUpdate)
                            // third argument specifies if it's an async request or a sync
                            xhr.addEventListener('load', function () {
                                if (this.readyState === 4) {
                                    if (this.status === 200) {
                                        resolve(JSON.parse(this.response))
                                    } else {
                                        reject(this.status)
                                    }
                                }
                            })
                            xhr.open("POST", urlUpdate)
                            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
                            xhr.send(formData)
                        }) // end of the promise
                            .then((data) => {
                                window.location.replace('/datos_profesionales')
                            })
                            .catch((error) => {
                                console.error(error)
                            })
                    }) //FIN SUBMIT EVENT
                    /*<!--START deleteProfilUser  */
                    $('.profile_user_delete').click(function (){
                        var deleteId = $(this).data('id');
                        let urlDeleteProfilUser = Routing.generate("deleteUserProfile",{id:deleteId});
                        let xhr = new XMLHttpRequest();
                        xhr.open('GET', urlDeleteProfilUser, true);
                        xhr.onload = function () {
                            window.location.replace('/datos_profesionales')
                        };
                        xhr.send(null);
                    })
                    /* FIN deleteProfilUser--> */
                });//Finish load data
        })
        /* FINISH PASSING DATA TO MODAL for the Update User Profile --> */

         /*<!--START deleteProyect  */
         $('.delete-proyect').click(function (){
            var deleteId = $(this).data('id');
            let urlDeleteProyect = Routing.generate("deleteProyect",{id:deleteId});
            let xhr = new XMLHttpRequest();
            xhr.open('GET', urlDeleteProyect, true);
            xhr.onload = function () {
                window.location.replace('/vista_usuario/datos_proyectos')
            };
            xhr.send(null);
        })
        /* FIN deleteUser--> */

        /*<!--START deleteProfilProyect  */
        $('.profile_proyect_delete').click(function (){
            var deleteId = $(this).data('id');
            var proyectId = $(this).data('proyect-id');
            let urlDeleteProfilProyect = Routing.generate("deleteProfileProyect",{id:deleteId});
            let xhr = new XMLHttpRequest();
            xhr.open('GET', urlDeleteProfilProyect, true);
            xhr.onload = function () {
                window.location.replace('/vista_usuario/add_proyecto/step_2/'+proyectId)
            };
            xhr.send(null);
        })
        /* FIN deleteProfilProyect--> */
        
        /*<!--START deleteNeedsProfil  */
        $('.needs-profile-delete').click(function (){
            var deleteId = $(this).data('id');
            var proyectId = $(this).data('proyect-id');
            let urlDeleteNeedsProfil = Routing.generate("deleteProfileNeeds",{id:deleteId});
            let xhr = new XMLHttpRequest();
            xhr.open('GET', urlDeleteNeedsProfil, true);
            xhr.onload = function () {
                window.location.replace('/vista_usuario/add_proyecto/step_3/'+proyectId)
            };
            xhr.send(null);
        })
        /* FIN deleteNeedsProfil--> */

        /*<!--START showhide Team Member number  */
        $('#project_project_team').click(function(){            
            $('#project_project_team_number').toggleClass('hide-e');
        })
        /*<!--FIN showhide Team Member number  */

        /*<!--START showhide Deal  */
        $('select#needs_project_needs_deal').change(function() {
            var arrOption = ['% Empresa','% Ventas'];
            var showPecent =arrOption.indexOf($(this).val());
            if(showPecent != -1){
                $('#needs_project_needs_percent').removeClass('hide-e');
            }else{
                $('#needs_project_needs_percent').addClass('hide-e');
            }
            
        })

        /* EDIT*/
        /*<!--START showhide Deal  */
        $('.modal-edit-needs-project').click(function(){
            let needId = $(this).data('id');                        
            $('select#proyects_form_'+needId+'_needs_deal').change(function() {
                var arrOption = ['% Empresa','% Ventas'];
                var showPecent =arrOption.indexOf($(this).val());
                
                if(showPecent != -1){
                    $('#proyects_form_'+needId+'_needs_percent').removeClass('hide-e');
                }else{
                    $('#proyects_form_'+needId+'_needs_percent').addClass('hide-e');
                }
                
            })
        
        })
        
        /*<!--FIN showhide Deal  */

/* <!-- START PROJECT INTEREST */
        $('select#interest_project_interest_profil').change(function(){
            console.log('Se cambio');
            console.log($(this).find("option:selected").text());

            let urlDeleteNeedsProfil = Routing.generate("MatchProject");
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    console.log((xhr.response));
                }
            }
            

            xhr.open('GET', urlDeleteNeedsProfil, true);
            xhr.onload = function () {
               // window.location.replace('/vista_usuario/add_proyecto/step_3/'+proyectId)
            };
            xhr.send(null);

        })
        $('.profile_project_interest').click(function(){
            $('select#interest-select-profile').change(function(){
                console.log($(this).val());                
            })
        })
        $('.btnEndInterest1').click(function(){
            $('#interest-step-1').addClass('hide-e');
            $('#interest-step-2').removeClass('hide-e');
        })

        $('select#interest_project_interest_deal').change(function() {
            var arrOption = ['% Empresa','% Ventas'];
            var showPercent =arrOption.indexOf($(this).val());
            if(showPercent != -1){

                $('.needs_project_needs_percent').removeClass('hide-e');
            }else{

                $('.needs_project_needs_percent').addClass('hide-e');
            }
            
        })


/* Fin PROJECT INTEREST --> */


/* FIN Modal Form Script -->*/

/* <!-- START function for Multi Step Form into addProyect*/

        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab-multi-form");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
        }

        $('.nextPrev').click(function (){
            var n = $(this).data('next');
            
                // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab-multi-form");
            // Exit the function if any field in the current tab is invalid:
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("project_form").submit();
                //return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
            })//FIN NextPrex

        function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
        }

/* FIN function for Multi Step Form into addProyect -->*/

/**/ 
})(jQuery);    
    
   