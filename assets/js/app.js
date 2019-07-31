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

function  arrMatchTxt (profil,dealArr, projectName){

    var deal = dealArr.deal != null ? dealArr.deal:'';
    var percent = dealArr.percent !=0 ? dealArr.percent:''; //Check if Percent is 0
    var matchText = {
        'match':{
            'headerTextDeal':'Quieres participar en el proyecto <b>'+projectName+'</b>,con tu perfil de <b>'+profil+'</b> con un acuerdo de <b>'+percent+deal+'</b> y exponen en su propuesta:',
            'headerText':'Quieres participar en el proyecto <b>'+projectName+'</b>,que necesita el perfil de <b>'+profil+'</b>',
            'descriptionText':'Esto es una propuesta cerrada, pero no la negociación física.<br/> Recuerda, esto establece unas bases para negociar, se coherente con lo que vas a pedir porque puede llevar a malos entendidos y pérdidas de tiempo.'
            },
        'noMatchProfilProject':{//Cuando el Proyecto no busca el perfil pero el user lo tiene
            'headerText':'El proyecto no busca <b>'+profil+'</b>, ¿Quieres ofrecer tu propuesta de todos modos?',
            'descriptionText':'Esto es una propuesta cerrada, pero no la negociación física, Recuerda, esto establece unas bases para negociar, se coherente con lo que vas a pedir porque puede llevar a malos entendidos y pérdidas de tiempo.'
            },
        'noMatchProjectProfil':{//Cuando el Proyecto busca el perfil y el user no lo tiene
            'headerText':'El perfil <b>'+profil+'</b> no lo tienes activo no hay problema, hazlo ahora y se te guardará en datos profesionales.',
            'headerTextDeal':'El perfil <b>'+profil+'</b> no lo tienes activo no hay problema, hazlo ahora y se te guardará en datos profesionales.',
            'headerTextMax':'El perfil <b>'+profil+'</b> no lo tienes activo.',
            'descriptionTextMax':'Lo sentimos pero has llegado al maximo de <b>4 perfiles</b>.Ve a <a href="/datos_profesionales" class="ver_color">Datos Profesionales</a> y revisa tus perfiles.'
        },
        'subscribeAlready':{
            'headerText':'Ya te has interesado por este proyecto con este mismo perfil, así que no enviaremos tu interes por este proyecto.<br/>Pero puedes intentarlo con otro perfil si lo deseas.',
            'descriptionText':''
        },
        'noMatch':{ //Ni el use no tiene el perfil ni el proyecto lo necesita
            'headerText':' Este Proyecto no busca ninguno de tus perfiles ni tampoco busca <b>'+profil+'</b>',
            'descriptionText':'Puedes ir a datos profesoniales y dar de alta algun perfil que el proyecto demande o puedes intersarte por algun perfil que el proyecto demande'
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

//We change the dropdown for Perfil into Project Interes , better do it on the contreler when you will have time
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
    let urlDeleteNeedsProfil = Routing.generate("MatchProject",{userid:userid,projectid:projectid});
         
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
                    console.log('Before unique DropDwon',projectProfilDropdown);
                    projectProfilDropdown = Array.from(new Set(projectProfilDropdown));

                    $("select#interest_project_interest_profil option").remove();
                    $("select#interest_project_interest_profil").append('<option value="100">Selecciona un perfil</option>');
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
           
            let urlDeleteNeedsProfil = Routing.generate("MatchProject",{userid:userid,projectid:projectid});
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
                            $('#interest_project_interest_description').val(projectInterestDescriptionToAdd).prop('disabled',true);
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
                $('#interest_project_interest_description').val(projectInterestDescriptionToAdd).prop('disabled',true);
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
        'noMatchProfilProject':{//Cuando el Proyecto no busca el perfil pero el user lo tiene
            'headerText':'Para tu proyecto <b>'+project+'</b> no demandas el perfil <b>'+profil+'</b>, pero no hay problema, hazlo ahora y se guardará en el perfil del proyecto.',
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

    var projectSelectedId = $('#interest_profile_interest_project option:selected').val();
    var profileSelectedId = $('#interest_profile_interest_profile option:selected').val();
    var userId =$('.interestdata').data('usrperfilid');
    
    console.log('Project', projectSelected);
    console.log('Profile', profileSelected);
    console.log('projectSelected',projectSelectedId);
    console.log('userId',userId);
    console.log('profilUserId',profilUserId);
    console.log('profilUserName',profilUserName)
    console.log('profilSector',profileSector);
    console.log('profileSelectedId',profileSelectedId);

            let urlDeleteNeedsProfil = Routing.generate("MatchProject",{userid:userId,projectid:projectSelectedId});
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
                        $('#interest_profile_interest_description').val(deal.description).prop('disabled',true);
                    
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


        $('select#interest_profile_extra_profil_deal_add').change(function() {
            var arrOption = ['% Empresa','% Ventas'];
            var showPercent =arrOption.indexOf($(this).val());
            if(showPercent != -1){
                $('.needs-profile-add-percent').removeClass('hide-e');
            }else{
                $('.needs-profile-add-percent').addClass('hide-e');
            }
            
        })

/* FIN PROFILE INTEREST --> */


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
    
   