import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router'
/* Liviu NICO
php bin/console fos:js-routing:debug To see all the routs from FOS
php bin/console fos:js-routing:dump --format=json --target=assets/js/js_routes.json   -- Liviu,Nico you have to run this command in order to get all the paths into json
*/

import Routes from './js_routes.json'
import 'slick-carousel';
Routing.setRoutingData(Routes)
const $ = require('jquery');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
require('bootstrap/js/dist/tooltip');
require('bootstrap/js/dist/popover');
require('slick-carousel');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

$(document).ready(function() {
       
    $('.slick-projects').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: true,
        variableWidth: true,
        arrows : false,
        //autoplay: true,
        //autoplaySpeed: 2000,        
      }); 
    
      $("#homeModal").modal('show');

});
require('bootstrap/js/dist/util.js')

$(function(){
    $('[rel=popover]').popover({ 
      html : true ,
      container: 'body',
      content: function() {
        return $('#popover_content').html();
      }
    });    
  });

    /*==================================================================
    [ Validate LOGIN ]*/

    (function ($) {
        "use strict";
    var input = $('.validate-input .input100');
    
    /* START NOTIFY UPDATE*/
    $(document).on('click','.notify',function(){
        var notifyID =$(this).data('notify-id');
        $.post("/user/notification-update/"+notifyID )
        .done(function(response) {            
            console.log('Notify Update')            
        })
        .fail(function(response) {
            console.log('Error - Notify Update')
        });
            
    });
    /* FIN NOTIFY UDDATE*/

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

    /* START FILTER ProjectS*/
     
     $('.filter-Projects').click(function(){
        var sector = $( "select#select-sector" ).val();
        var km =$(".Project-km").val();
        var lat = 0;
        var long = 0;
        var urlProjectFilter='';        
        let notBlocked= false;
      
        sector = isNaN(sector) ? 0:sector;

        if(km != ''){
            if (navigator.geolocation) {
                let notBlocked= true;
                navigator.geolocation.getCurrentPosition(function(position) {
                   let lat = position.coords.latitude ? position.coords.latitude : lat
                   let long = position.coords.longitude ? position.coords.longitude :long
                   urlProjectFilter = Routing.generate('projects-filter',{sector:sector,km:km,lat:lat,long:long})
                   window.location.replace(urlProjectFilter)               
                });
              } else {
                // Browser doesn't support Geolocation
                console.log("Para utilizar el filtro de distancia necesitamos que permitas tu localización ");       
              }
        }else{
            km=0;
            urlProjectFilter = Routing.generate('projects-filter',{sector:sector,km:km,lat:lat,long:long})
            window.location.replace(urlProjectFilter)  
        }
    })

    /*Fin FILTER ProjectS*/

    /* START FILTER PROFILES*/
     
    $('.filter-profiles').click(function(){
        var profiles = $( "select#select-profiles" ).val();
        var km =$(".Project-km").val();
        var lat = 0;
        var long = 0;
        var urlProjectFilter='';        
        profiles = isNaN(profiles) ? 0:profiles;
        console.log(km);
      
        if(km != ''){
            if (navigator.geolocation) {
               
                navigator.geolocation.getCurrentPosition(function(position) {
                   let lat = position.coords.latitude ? position.coords.latitude : lat
                   let long = position.coords.longitude ? position.coords.longitude :long
                   urlProjectFilter = Routing.generate('profiles-filter',{profiles:profiles,km:km,lat:lat,long:long})
                   window.location.replace(urlProjectFilter)               
                });
              } else {
                // Browser doesn't support Geolocation
                console.log("Para utilizar el filtro de distancia necesitamos que permitas tu localización ");       
              }
        }else{
            km=0;
            urlProjectFilter = Routing.generate('profiles-filter',{profiles:profiles,km:km,lat:lat,long:long})
            window.location.replace(urlProjectFilter)  
        }
    })

    /*Fin FILTER PROFILES*/
   
    /* <!-- START Modal Form Script*/
   
    /*<!--START AddProfil user */

  

        $('.add-profil').click(function () {
            let urlAddProfil = Routing.generate('add-profile');
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
                                window.location.replace('/user/professional-info')
                            };
                    }) //FIN SUBMIT EVENT
            })
        })
    /* FIN AddProfil user --!> */
    
    /* <!-- START PASSING DATA TO MODAL for the Update User Profile */
    $('.select_Profile').click(function (){
        var profilId= $(this).data("id");
        var profil=$(this).data("profil");
        var sector =$(this).data("sector");
        
        //Remove selected first ToDo
        $("#profile_user_profil option").prop("selected", false);
        $("#profile_user_sector option").prop("selected", false)
        
        $("#profile_user_profil option:contains(" + profil +")").attr("selected", true);
        $("#profile_user_sector option:contains(" + sector +")").attr("selected", true);
        

        let url = Routing.generate('edit-profile',{id:profilId})
        $.get(url, function (data) {
            $(".modal-content").html(data);
                //Liviu, Nico we send the data here avter we bind the DATA to Modal Content

                 /*Remove selected first ToDo
                 This is hack into html Liviu, Nico you have to fixed into modal/AddProfile.html {value:'Profile.sector'} no is not working
                 */
                $("#profile_user_profil option").prop("selected", false);
                $("#profile_user_sector option").prop("selected", false)
                
                $("#profile_user_profil option:contains(" + profil +")").attr("selected", true);
                $("#profile_user_sector option:contains(" + sector +")").attr("selected", true);


                let formProfileUserUpdate = document.getElementById('profile_user');
                formProfileUserUpdate.addEventListener('submit', function (event) {
            
                    let urlUpdate = Routing.generate('profil-update',{id:profilId})
                    
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
                                window.location.replace('/user/professional-info')
                            })
                            .catch((error) => {
                                console.error(error)
                            })
                    }) //FIN SUBMIT EVENT
                    /*<!--START deleteProfilUser  */
                    $('.profile_user_delete').click(function (){
                        var deleteId = $(this).data('id');
                        let urlDeleteProfilUser = Routing.generate("delete-profile",{id:deleteId});
                        let xhr = new XMLHttpRequest();
                        xhr.open('GET', urlDeleteProfilUser, true);
                        xhr.onload = function () {
                            window.location.replace('/user/professional-info')
                        };
                        xhr.send(null);
                    })
                    /* FIN deleteProfilUser--> */
                });//Finish load data
        })
        /* FINISH PASSING DATA TO MODAL for the Update User Profile --> */

         /*<!--START deleteProject  */
         $('.delete-Project').click(function (){
            var deleteId = $(this).data('id');
            let urlDeleteProject = Routing.generate("delete-project",{id:deleteId});
            let xhr = new XMLHttpRequest();
            xhr.open('GET', urlDeleteProject, true);
            xhr.onload = function () {
                window.location.replace('/user/projects-info')
            };
            xhr.send(null);
        })
        /* FIN deleteUser--> */

        /*<!--START deleteProfilProject  */
        $('.profile_Project_delete').click(function (){
            var deleteId = $(this).data('id');
            var ProjectId = $(this).data('Project-id');
            let urlDeleteProfilProject = Routing.generate("delete-profile-project",{id:deleteId});
            let xhr = new XMLHttpRequest();
            xhr.open('GET', urlDeleteProfilProject, true);
            xhr.onload = function () {
                window.location.replace('/user/add-project/profile/'+ProjectId)
            };
            xhr.send(null);
        })
        /* FIN deleteProfilProject--> */
        
        /*<!--START deleteNeedsProfil  */
        $('.needs-profile-delete').click(function (){
            var deleteId = $(this).data('id');
            var ProjectId = $(this).data('Project-id');
            let urlDeleteNeedsProfil = Routing.generate("delete-profile-needs",{id:deleteId});
            let xhr = new XMLHttpRequest();
            xhr.open('GET', urlDeleteNeedsProfil, true);
            xhr.onload = function () {
                window.location.replace('/user/add-project/project-needs/'+ProjectId)
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
            $('select#Projects_form_'+needId+'_needs_deal').change(function() {
                var arrOption = ['% Empresa','% Ventas'];
                var showPecent =arrOption.indexOf($(this).val());
                
                if(showPecent != -1){
                    $('#Projects_form_'+needId+'_needs_percent').removeClass('hide-e');
                }else{
                    $('#Projects_form_'+needId+'_needs_percent').addClass('hide-e');
                }
                
            })
        
        })
        
        /*<!--FIN showhide Deal  */

/* <!-- START PROJECT INTEREST */

function  arrMatchTxt (profil,dealArr, projectName){
    console.log(dealArr);
    console.log('Perceeeent',dealArr.precent);

    var deal = dealArr.deal != null ? dealArr.deal:'';
    var percent = dealArr.percent != undefined ? dealArr.percent:''; //Check if Percent is 0
    var matchText = {
        'match':{
            'headerTextDeal':'Quieres participar en el project <b>'+projectName+'</b>,con tu Profile de <b>'+profil+'</b> con un acuerdo de <b>'+percent+deal+'</b> y exponen en su propuesta:',
            'headerText':'Quieres participar en el project <b>'+projectName+'</b>,que necesita el Profile de <b>'+profil+'</b>',
            'descriptionText':'Esto es una propuesta cerrada, pero no la negociación física.<br/> Recuerda, esto establece unas bases para negociar, se coherente con lo que vas a pedir porque puede llevar a malos entendidos y pérdidas de tiempo.'
            },
        'noMatchProfilProject':{//Cuando el project no busca el Profile pero el user lo tiene
            'headerText':'El project no busca <b>'+profil+'</b>, ¿Quieres ofrecer tu propuesta de todos modos?',
            'descriptionText':'Esto es una propuesta cerrada, pero no la negociación física, Recuerda, esto establece unas bases para negociar, se coherente con lo que vas a pedir porque puede llevar a malos entendidos y pérdidas de tiempo.'
            },
        'noMatchProjectProfil':{//Cuando el project busca el Profile y el user no lo tiene
            'headerText':'El Profile <b>'+profil+'</b> no lo tienes activo no hay problema, hazlo ahora y se te guardará en datos profesionales.',
            'headerTextDeal':'El Profile <b>'+profil+'</b> no lo tienes activo no hay problema, hazlo ahora y se te guardará en datos profesionales.',
            'headerTextMax':'El Profile <b>'+profil+'</b> no lo tienes activo.',
            'descriptionTextMax':'Lo sentimos pero has llegado al maximo de <b>4 perfiles</b>.Ve a <a href="/user/professional-info" class="ver_color">Datos Profesionales</a> y revisa tus perfiles.'
        },
        'subscribeAlready':{
            'headerText':'Ya te has interesado por este project con este mismo Profile, así que no enviaremos tu interes por este project.<br/>Pero puedes intentarlo con otro Profile si lo deseas.',
            'descriptionText':''
        },
        'noMatch':{ //Ni el use no tiene el Profile ni el project lo necesita
            'headerText':' Este project no busca ninguno de tus perfiles ni tampoco busca <b>'+profil+'</b>',
            'descriptionText':'Puedes ir a datos profesoniales y dar de alta algun Profile que el project demande o puedes intersarte por algun Profile que el project demande'
        }
    }
    return matchText;
}

function matchProjectProfile(profileSelected,arrMatch){

    var match =arrMatch['matchProfile'].indexOf(profileSelected);
        if(match != -1){
            return 'match';   
        }

    var noMatchProjectProfil =arrMatch['needsProfileProject'].indexOf(profileSelected);
        if(noMatchProjectProfil != -1){
            return 'noMatchProjectProfil';   
        }
    
    var noMatchProfilProject =arrMatch['needsProfileProject'].indexOf(profileSelected);
    var userProfiles =arrMatch['usersProfiles'].indexOf(profileSelected);
        if( (noMatchProfilProject == -1) && (userProfiles !=-1) ){
            return 'noMatchProfilProject';   
        }
    
    var noMatchProfilProject =arrMatch['needsProfileProject'].indexOf(profileSelected);
    var userProfiles =arrMatch['usersProfiles'].indexOf(profileSelected);
        if( (noMatchProfilProject == -1) && (userProfiles == -1) ){
            return 'noMatch';   
        }
    
}
var headerToAddProject = '';
var descriptionToAddProject='';
var projectInterestDescriptionToAdd='';

//We get the user and project id for the mathcProject tequest
var userid = $('.interestdata').data('userid');
var projectid = $('.interestdata').data('projectid');

//We change the dropdown for Profile into Project Interes , better do it on the contreler when you will have time
var projectProfilDropdown= [];//array
var arrProfile ={
    'Marketing':1,
	'Diseño':2,
	'Programación':3,
	'Legal':4,
	'Comercial':5,
	'Financiero':6,
	'Espacio Físico':7,
	'Financiación':8
}
$('.projectInterstMe').click(function(){
    let urlDeleteNeedsProfil = Routing.generate("match-project",{userid:userid,projectid:projectid});
         
            new Promise(function (resolve, reject) {
                let xhr = new XMLHttpRequest()
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
                xhr.open("POST", urlDeleteNeedsProfil)
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
                xhr.send(null)
            }) // end of the promise
                .then((data) => {
                    //we create the dropdown                    
                    projectProfilDropdown  = data['needsProfileProject'];
                    $.merge(projectProfilDropdown,data['usersProfiles']);                    
                    projectProfilDropdown = Array.from(new Set(projectProfilDropdown));

                    $("select#interest_project_interest_profil option").remove();
                    $("select#interest_project_interest_profil").append('<option value="100">Selecciona un Profile</option>');
                    for (var i=0;i<projectProfilDropdown.length;i++){
                        $("select#interest_project_interest_profil").append('<option value="'+arrProfile[projectProfilDropdown[i]]+'">'+projectProfilDropdown[i]+'</option>');
                     }
                })
                .catch((error) => {
                    console.error(error)
                    //$('.interest-title').append('<p>Ha occurido un error por favor empinza de nuevo</p>');
                })
});

$('select#interest_project_interest_profil').change(function(){          
            var projectTitle = $('.project-title').text();
            var profileSelected = $(this).find("option:selected").text();
            //console.log($(this).find("option:selected").text());
           
            let urlDeleteNeedsProfil = Routing.generate("match-project",{userid:userid,projectid:projectid});
            new Promise(function (resolve, reject) {
                let xhr = new XMLHttpRequest()
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
                xhr.open("POST", urlDeleteNeedsProfil)
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
                xhr.send(null)
            }) // end of the promise
                .then((data) => {
                    console.log('Datoos ---',data)
                    var responseType = matchProjectProfile(profileSelected,data);
                    var deal  = data['profileProjectDeal'][profileSelected];
                    deal = deal != null ? deal:'';

                    if(deal != null){
                        deal = deal;
                        projectInterestDescriptionToAdd = deal.description;
                        console.log('Deal Description -->'+projectInterestDescriptionToAdd);
                    }else{
                        deal='';
                    }                  
                    
                    console.log('deeeal-->'+deal.deal);
                    console.log('profileSelected-->'+profileSelected);
                    console.log('deeeal VVVVV-->'+deal);
                    console.log('projectTitle-->'+projectTitle);
                    
                    var matchTxt = arrMatchTxt(profileSelected,deal,projectTitle);
                    console.log('Response Type --> '+responseType)
                    console.log('MatchTxt',matchTxt[responseType] );

                    //Add the new text for the modal 
                    headerToAddProject = deal !='' ? matchTxt[responseType]['headerTextDeal']:matchTxt[responseType]['headerText'];
                    descriptionToAddProject = matchTxt[responseType]['descriptionText'];  

                    if (responseType =='noMatchProjectProfil'){
                        console.log(' ---- No more Profile ----',data['usersProfiles'].length);
                        if(data['usersProfiles'].length >= 4){
                            console.log(' ---- No more Profile ----');
                            
                            $('#interest_project_submit').prop("disabled",true);
                            $('#interest_project_extra_profile_des').addClass('hide-e');

                            headerToAddProject =matchTxt[responseType]['headerTextMax'];
                            descriptionToAddProject = matchTxt[responseType]['descriptionTextMax'];  
                        }else{
                            $('.add-profil-project').removeClass('hide-e');
                            $('.btnEndAddProfile').removeClass('hide-e');
                            
                            $('.needs_project_needs_sector').removeClass('hide-e');
                            $('#interest_project_extra_profile_des').removeClass('hide-e');
                            
                            $('#interest_project_submit').addClass('hide-e');
                                                      
                            //interest_project_submit hide Send button
                            descriptionToAddProject = '';  
                        } 
                        $('#interest_project_interest_description').addClass('hide-e');                       
                        

                        $('.btnEndAddProfile').click(function(){                            
                            $('.add-profil-project').removeClass('hide-e');
                            $('#interest_project_interest_description').removeClass('hide-e');
                            $('#interest_project_submit').removeClass('hide-e');
                            //we hide the form for Description
                            $('.btnEndAddProfile').addClass('hide-e');
                            $('.needs_project_needs_sector').addClass('hide-e');
                            $('#interest_project_extra_profile_des').addClass('hide-e');

                            //We set the text to show
                            headerToAddProject = deal !='' ? matchTxt['match']['headerTextDeal']:matchTxt['match']['headerText'];
                            descriptionToAddProject = matchTxt['match']['descriptionText'];    
                            
                            //Muy mal , tienes que rehacer este codigo para que no llames 2 veces lo mismo
                            if(deal != null){
                                deal = deal;
                                projectInterestDescriptionToAdd = deal.description;                               
                            }     

                            $('.interstAppendHeader').remove();
                            $('.interstAppendDescription').remove();
                            
                            $('.interest-title').append('<p class="interstAppendHeader">'+ headerToAddProject+'</p>');
                            $('textarea#interest_project_interest_description').after('<p class="interstAppendDescription">'+descriptionToAddProject+'</p>');
                            $('#interest_project_interest_description').val(projectInterestDescriptionToAdd);
                        })
                        projectInterestDescriptionToAdd=undefined; //We do this to give the oportunity to the user to add his descriptionin and to overwritet the projrct description
                    }
                    if (responseType =='noMatchProfilProject'){
                        
                        $('.add-profil-project').removeClass('hide-e');
                        $('.needs_project_needs_deal').removeClass('hide-e');
                        projectInterestDescriptionToAdd=undefined; //We do this to give the oportunity to the user to add his descriptionin and to overwritet the projrct description
                        descriptionToAddProject='';
                    }
                    
                     
                })
                .catch((error) => {
                    console.error(error)
                    //$('.interest-title').append('<p>Ha occurido un error por favor empinza de nuevo</p>');
                })
        })
        
        $('.btnEndInterest1').click(function(){
            if(projectInterestDescriptionToAdd !== undefined){
                $('#interest_project_interest_description').val(projectInterestDescriptionToAdd);
            }
            $('.interest-title').append('<p class="interstAppendHeader">'+ headerToAddProject+'</p>');
            $('textarea#interest_project_interest_description').after('<p class="interstAppendDescription">'+descriptionToAddProject+'</p>');
            $('#interest-step-1').addClass('hide-e');
            $('#interest-step-2').removeClass('hide-e');            
        })

        $('.btnEndInterest1-Atras').click(function(){
            $('#interest-step-1').removeClass('hide-e');
            $('#interest_project_interest_description').removeClass('hide-e');
            $('#interest_project_extra_profile_des').addClass('hide-e');
            $('#interest_project_submit').prop("disabled",false);
            $('#interest_project_submit').removeClass('hide-e');
            $('#interest-step-2').addClass('hide-e');
            $('.add-profil-project').addClass('hide-e');
            $('.needs_project_needs_deal').addClass('hide-e');
            $('.interstAppendHeader').remove();
            $('.interstAppendDescription').remove();
            $('#interest_project_interest_description').val('');
            $('#interest_project_interest_description').prop('disabled',false);
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

        $('.project_interest_3').click(function(){
            $('#interest-step-3').removeClass('hide-e');
            $('#interest-step-2').addClass('hide-e');
            $('.interstAppendHeader').addClass('hide-e');
        })

        $('.project_interest_2_atras').click(function(){
            $('#interest-step-3').addClass('hide-e');
            $('#interest-step-1').addClass('hide-e');
            $('#interest-step-2').removeClass('hide-e');
            $('.interstAppendHeader').removeClass('hide-e')
        })

        $('select#interest_project_coworking').change(function() {
        
            var coworkID =$(this).val();
            $.get('/coworking/json/'+coworkID)
            .done(function(response) {
                var data = $.parseJSON(response);
                console.log(data)
                $('.co-name').text(data.name);
                $('.co-address').text(data.address);
                $('.co-phone').text(data.phone);
                $('.co-description').text(data.description);
                $('.co-img').attr('src','/media/cache/coworking_thumb/build/img/uploads/coworking_img/'+data.img);

            })
            .fail(function(response) {
                console.log('Failed',response)
            });
            
        })


/* Fin PROJECT INTEREST --> */


/* <!-- START PROFILE INTEREST */

function  arrProfileMatchTxt (profil,sector,project,usrProfileName,dealArr){

    var deal = dealArr.deal != null ? dealArr.deal+'</b>':'';
    var percent = dealArr.percent !='' ? 'ofreciendo un <b>'+dealArr.percent:''; //Check if Percent is 0

    
    var matchText = {
        'match':{
            'headerText':'Quieres contactar con el usuario <b>'+usrProfileName+'</b>, por su experiencia en <b>'+profil+'</b> en el sector de <b>'+sector+'</b> '+ percent +' '+deal +' y expones en tu propuesta:',
            'descriptionText':''
            },
        'noMatchProfilProject':{//Cuando el project no busca el Profile pero el user lo tiene
            'headerText':'Para tu project <b>'+project+'</b> no demandas el Profile <b>'+profil+'</b>, pero no hay problema, hazlo ahora y se guardará en el Profile del project.',
            'descriptionText':''
            },
    }
    return matchText;
}


function matchProfileProject(profileSelected,arrMatch){
   
    var match =arrMatch['needsProfileProject'].indexOf(profileSelected);
        if( match != -1){
                return 'match';   
        }

    var noMatchProfilProject =arrMatch['needsProfileProject'].indexOf(profileSelected);
        if( noMatchProfilProject == -1){
            return 'noMatchProfilProject';   
        }
}


$('.profile_interest_1').click(function() {
    var projectSelected = $('#interest_profile_interest_project option:selected').text();
    var profileSelected = $('#interest_profile_interest_profile option:selected').text();
    var profilUserName  =   $('.profiluserId').data('profilusername');
    var profilUserId  =   $('.profiluserId').data('profiluserid');
    var profileSector =   $('.profile-sector').data(profileSelected.toLowerCase());

    var projectSelectedId = $('#interest_profile_interest_project option:selected').text();
    var profileSelectedId = $('#interest_profile_interest_profile option:selected').val();
    var userId =$('.interestdata').data('usrprofileid');
    
    console.log('Project', projectSelected);
    console.log('Profile', profileSelected);
    console.log('projectSelected',projectSelectedId);
    console.log('userId',userId);
    console.log('profilUserId',profilUserId);
    console.log('profilUserName',profilUserName)
    console.log('profilSector',profileSector);
    console.log('profileSelectedId',profileSelectedId);

            let urlDeleteNeedsProfil = Routing.generate("match-project",{userid:userId,projectid:projectSelectedId});
            new Promise(function (resolve, reject) {
                let xhr = new XMLHttpRequest()
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
                xhr.open("POST", urlDeleteNeedsProfil)
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
                xhr.send(null)
            }) // end of the promise
                .then((data) => {
                    console.log(data)
                    var deal  = data['profileProjectDeal'][profileSelected];
                    deal = deal != null ? deal:'';
                    
                    var responseType = matchProfileProject(profileSelected,data);                  
                    
                   // profil,sector,project,usrProfileName,deal
    
                    var matchTxtProfile = arrProfileMatchTxt(profileSelected,profileSector,projectSelected,profilUserName,deal);
                    
                    console.log('Response Type --> '+responseType)
                    console.log('matchTxt '+matchTxtProfile)
                    console.log(matchTxtProfile[responseType]['headerText'])

                    //Add the new text for the modal 
                    
                    if (responseType =='match'){
                        $('.interest-profile-title').append('<p class="interstAppendHeader">'+matchTxtProfile[responseType]['headerText']+'</p>');
                        $('textarea#interest_profile_interest_description').after('<p class="interstAppendDescription">'+matchTxtProfile[responseType]['descriptionText']+'</p>');                        
                        $('#interest_profile_interest_description').val(deal.description);
                    
                    }else{
                        $('.interest-profile-title').append('<p class="interstAppendHeader">'+matchTxtProfile[responseType]['headerText']+'</p>');
                        $('textarea#interest_profile_interest_description').after('<p class="interstAppendDescription">'+matchTxtProfile[responseType]['descriptionText']+'</p>'); 
                        $('#interest_profile_extra_profil_deal_add').removeClass('hide-e');                   
                    }

                })
                .catch((error) => {
                    console.error(error)
                    //$('.interest-title').append('<p>Ha occurido un error por favor empinza de nuevo</p>');
                })

                
    
})

       

        $('.profile_interest_2').click(function(){
            $('#interest_profile_interest_description').val('');
            $('#interest_profile_interest_description').prop('disabled',false);
            $('#interest_profile_extra_profil_deal_add').addClass('hide-e');
        })

        $('.profile_interest_3').click(function(){
            $('#interest-step-3').removeClass('hide-e');
            $('#interest-step-2').addClass('hide-e');
            $('.interstAppendHeader').addClass('hide-e');
        })

        $('.profile_interest_2_atras').click(function(){
            $('#interest-step-3').addClass('hide-e');
            $('#interest-step-1').addClass('hide-e');
            $('#interest-step-2').removeClass('hide-e');
            $('.interstAppendHeader').removeClass('hide-e')
        })


        $('select#interest_profile_extra_profil_deal_add').change(function() {
            var arrOption = ['% Empresa','% Ventas'];
            var showPercent =arrOption.indexOf($(this).val());
            if(showPercent != -1){
                $('.needs-profile-add-percent').removeClass('hide-e');
            }else{
                $('.needs-profile-add-percent').addClass('hide-e');
            }
            
        })

        //HACKER KUNLABORI FIRST COWORKING
        $.get('/coworking/json/2')
            .done(function(response) {
                var data = $.parseJSON(response);
                $('.co-name').text(data.name);
                $('.co-address').text(data.address);
                $('.co-phone').text(data.phone);
                $('.co-description').text(data.description);
                $('.co-img').attr('src','/media/cache/coworking_thumb/build/img/uploads/coworking_img/'+data.img);

            })
            .fail(function(response) {
                console.log('Failed',response)
            });

        $('select#interest_profile_coworking').change(function() {
        
            var coworkID =$(this).val();
            $.get('/coworking/json/'+coworkID)
            .done(function(response) {
                var data = $.parseJSON(response);
                console.log(data)
                $('.co-name').text(data.name);
                $('.co-address').text(data.address);
                $('.co-phone').text(data.phone);
                $('.co-description').text(data.description);
                $('.co-img').attr('src','/media/cache/coworking_thumb/build/img/uploads/coworking_img/'+data.img);

            })
            .fail(function(response) {
                console.log('Failed',response)
            });
            
        })
        

/* FIN PROFILE INTEREST --> */


/* FIN Modal Form Script -->*/

/* <!-- START function for Multi Step Form into addProject*/

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

/* FIN function for Multi Step Form into addProject -->*/




/**/ 
})(jQuery);    
    
   