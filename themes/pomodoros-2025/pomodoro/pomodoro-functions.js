//BEFORE START CODE CHECK OUT README.MD OR GITHUB FOR FULL DOCUMENTATION

//SYSTEM VARS
{
	var debug = true;
	if(data_from_php.is_admin)
		var debug = true;
	//
	var doing_ajax = false;
	//
	var pomodoros_to_big_rest=4;

	var pomodoroTime = 1500;
	var restTime = 300;
	var bigRestTime = 1800;
	var intervalMiliseconds = 1000;

	//for testing
	//pomodoroTime = 15;restTime = 30;bigRestTime = 180;intervalMiliseconds = 10;

	//Dynamic clock var
	//var is_interrupt_button;
	var m1;
	var m2;
	var m3;
	var m4;
	var m1_current = 9;
	var m2_current = 9;
	var s1_current = 9;
	var s2_current= 9;

	//Pomodoro session control vars
	var pomodoro_actual = 1;
	var is_pomodoro = true; //is_pomodoros is when using timer for focusing (otherwise ir resting)
	var secondsRemaining = 0;//pomodoroTime;
	var interval_clock=false;

	//
	var noSleep;
	var artyom_voice;
	var soundManager;
	var volumeLevel;
	var pomodoro_completed_sound;
	var active_sound;
	var session_reseted_sound;
	active_sound = document.getElementById('active_sound');
	pomodoro_completed_sound = document.getElementById('pomodoro_completed_sound');
	session_reseted_sound =  document.getElementById('session_reseted_sound');
	//
	var autoAction=false; //if true dont need to click
	var autoCycle=false;
	//var autoCycleCurrent=jQuery("#current_cycle").val();// 1; //#current_cycle
	var autoCycleCurrent=1; //#current_cycle
	var qtdd_tasks;
	var listen_changes_on_task_form;

	//
	var color_default = "#000000";
	var color_focus = "#006633";
	var color_rest = "#990000";
	//var startedTimer;
	//2024 CAIU var tempoCotagem;//seconds
	//2024 caiu var tempTimer = 0;
	var secondsRemainingClock;//clock format MM:SS
	var isRunning=false;
}
function startTest() {
	alertify.success("Special demonstration configuration loaded");
	pomodoroTime = 5;
	restTime = 3;
	//bigRestTime = 1800;
	intervalMiliseconds = 0.1;
}
//With that line jQuery can use the selector ($) and jQuery use the selector (jQuery), without conflict
//jQuery.noConflict();

//jQuery.getScript("projectimer-pomodoros-shared-parts.js");

jQuery(document).ready(function ($) {
	//
	if(debug)
		console.log("ready()");
	
	// 🔥 RELÓGIO DIGITAL HH:mm
	atualizarRelogioDigital();
	setInterval(atualizarRelogioDigital, 30000);
	//
	jQuery("#action_button_id").click(function(e) {
		e.preventDefault();
		action_button()
	});
	jQuery("#action_button_id").prop("disabled", true);
	jQuery("#relogio").click(function(e) {
		e.preventDefault();
		action_button()
	});
	/*jQuery(".delete-task-model-btn").click(function(e) {
		e.preventDefault();
		delete_model(jQuery(this).data('modelid'));
	});*/
	jQuery("#session-reset-btn").click(function(e) {
		e.preventDefault();
		reset_pomodoro_session();
	});
	jQuery("#continuos-session-btn").click(function(e) {
		e.preventDefault();
		set_continuous_session();
	});
	jQuery("#cycle_empty").click(function(e) {
		e.preventDefault();
		cycle_list_update(true);
	});
	jQuery("#cycle_start").click(function(e) {
		e.preventDefault();
		cycle_list_play();
	});
	jQuery("#cycle_prev").click(function(e) {
		e.preventDefault();
		cycle_list_prev();
	});
	jQuery("#cycle_next").click(function(e) {
		e.preventDefault();
		cycle_list_next();
	});
	model_task_buttons_functions();
	
	//
	jQuery('input[type="range"]').rangeslider();
	//Voice recon and speech JS
	startContinuousArtyom();
	//
	startNoSleepWakeLock();
	//Sound library for Sound FX 
	//startSoundMan();

	//
	change_status(txt_loading_initial_data);	
	//
	load_initial_data();
	//
	secondsRemaining = pomodoroTime;
	convertSeconds(secondsRemaining);
	flip_number(true);
	
	//listen to changes
	jQuery("#title_box, #description_box, input[type=radio], #tags_box, #rangeVolume, #soundfx_enabled, #voice_enabled").change(function() {	
		update_pomodoro_clipboard();
	});
	//
	start_listen_changes_on_task_form();
});

function atualizarRelogioDigital() {
	const agora = new Date();

	let horas = agora.getHours().toString().padStart(2, '0');
	let minutos = agora.getMinutes().toString().padStart(2, '0');

	const elHoras = document.getElementById('relogio-horas');
	const elMinutos = document.getElementById('relogio-minutos');

	if (elHoras && elMinutos) {
		elHoras.textContent = horas;
		elMinutos.textContent = minutos;
	}
}

function start_listen_changes_on_task_form() {
	//Check updates on task every 15s (if not on focus)
	if(!listen_changes_on_task_form) {
		listen_changes_on_task_form = setInterval(function() {
			if(!jQuery("#title_box").is(":focus") && !jQuery("#tags_box").data('select2').isOpen() && !jQuery("#description_box").is(":focus") && !doing_ajax )
			load_initial_data();
		},15000);
	}
}

function model_task_buttons_functions() {
	jQuery("#botao-salvar-modelo").off("click").click(function(e) {
		e.preventDefault();
		save_model();
	});
	jQuery(".delete-task-model-btn").off("click").click(function(e) {
		e.preventDefault();
		delete_model(jQuery(this).data('modelid'));
	});
	jQuery(".remove-task-from-list-btn").off("click").click(function(e) {
		e.preventDefault();
		jQuery(this).parent().parent().remove();
		cycle_list_update();
		//delete_model(jQuery(this).data('modelid'));
	});
	
	jQuery("#contem-modelos .model-container").off("click").click(function(e) {
		e.preventDefault();
		load_model(jQuery(this).data('modelid'));
	});
	jQuery( "#contem-ciclo" ).sortable({
	  revert: true,
	  	over: function() {
	      removeIntent = false;
	    }, //Remove function
	    out: function() {
	      removeIntent = true;
	    },
	    beforeStop: function(event, ui) {
	      if (removeIntent == true) {
	        ui.item.remove();
	      }
		},
		receive: function (event, ui) {      
            cycle_list_update();
        }
	}).droppable({
        /*activeClass: "ui-state-default",
        hoverClass: "ui-state-hover",
        drop: function(event, ui) {
            var newClone = $(ui.helper).clone();
            $(this).after(newClone);
            $(this).height($(this).height+20);
        }
        drop: function(event, ui) {
        	update_cycle_list();
        },*/
        out: function(event, ui) {
        	cycle_list_update();
        }
    });

	jQuery( "#contem-modelos li" ).draggable({
		connectToSortable: "#contem-ciclo",
		snap: "#contem-ciclo",
		snapMode: "outer",
		helper: "clone",
		revert: "invalid",
		cursor: "move",
	});
	jQuery( "ul, li" ).disableSelection();
	//
	qtdd_tasks = jQuery('ul#contem-ciclo li').length;
}

function load_initial_data() {
	if(debug)
		console.log("load_initial_data()");
	
	doing_ajax = true;
	var data = {
		action: 'load_session',
	};
	jQuery.post(ajaxurl, data, function(response) {
		doing_ajax = false;
		if(response=="NOTIN")window.location.href = "/";

		// if(response==0) {
		// 	//alertify.error("Tarefa não encontrada");
		// 	change_status(txt_no_task_found);
		// } else {
			if(!jQuery("#title_box").is(":focus") && !jQuery("#tags_box").is(":focus") && !jQuery("#description_box").is(":focus") && !doing_ajax) {

			var postReturned = jQuery.parseJSON( response.slice( 0 ) );
			
			title_box.value = postReturned['post_title'];
			tags_box.value  = postReturned['post_tags'];
			description_box.value = postReturned['post_content'];
			data_box.value = postReturned['post_data'];
			status_box.value = postReturned['post_status'];
			post_id_box.value = postReturned['ID'];
			secondsRemainingFromPHP = postReturned['secondsRemainingFromPHP'];
			if(debug)
				console.log("interval_clock", interval_clock, " is_pomodoro", is_pomodoro);
			if(secondsRemainingFromPHP>0) {
				secondsRemaining=secondsRemainingFromPHP;
				if(!interval_clock)
					start_clock();
			} else {
				//if((secondsRemainingFromPHP*-1)>180) {
					//se passou mais de 3 minutos
					if(interval_clock && is_pomodoro)
						interrupt();
				//}
			}
			//COPY
			tags = postReturned['post_tags'];

			//
			jQuery('#tags_box').empty();
			if(tags) {
				//
				jQuery('#tags_box').append('<optgroup label="'+txt_in_use+'">');
				jQuery.each(tags, function(i) {
					text_variable = tags[i];
					jQuery('#tags_box').append( '<option value="'+text_variable+'" selected=selected>'+text_variable+'</option>' );
				});
				jQuery('#tags_box').append('</optgroup>');
			}

			tags_list = postReturned['tags_total'];
			///
			if(tags_list) {
				jQuery('#tags_box').append('<optgroup label="'+txt_available+'">');
				jQuery.each(tags_list, function(i) {
					text_variable = tags_list[i];
					jQuery('#tags_box').append( '<option value="'+text_variable+'">'+text_variable+'</option>' );
				});
				jQuery('#tags_box').append('</optgroup>');
			}
			if(postReturned['post_category']) {
				cat_list = postReturned['post_category'];
				cat_is = cat_list[0]==1 ? cat_list[1] : cat_list[0];
				jQuery('input[name=cat_vl][value='+cat_is+']').attr('checked', true); 
			}
			document.getElementById("secondsRemaining_box").value=secondsRemaining + "s";
			//
			volumeLevel=postReturned['range_volume'];
			jQuery("#rangeVolume").val(volumeLevel);
			//soundManager.volume(volumeLevel);
			//pomodoro_completed_sound.volume = volumeLevel;
			//active_sound.volume = volumeLevel;
			//session_reseted_sound.volume = volumeLevel;

			senabled = (postReturned['soundfx_enabled'] === 'true');
			jQuery("#soundfx_enabled").prop("checked", senabled);
			venabled = (postReturned['voice_enabled'] === 'true');
			jQuery("#voice_enabled").prop("checked", venabled);
			//alert(volumeLevel);
			//if(volumeLevel>1)
				//startContinuousArtyom();
			if(artyom_voice!=undefined && volumeLevel>1 )
				artyom_voice.initialize({volume:volumeLevel/100});
			}
		// }
		//
		if(jQuery("#action_button_id").is(':disabled')) {
			jQuery("#action_button_id").val(textPomodoro);
			jQuery("#action_button_id").prop("disabled", false);	
		}
	});

	jQuery('#tags_box').select2({
		tags: true,
		//closeOnSelect: false,
		//maximumSelectionLength: 3,
		//createSearchChoice: true,
		width: '100%',
		tokenSeparators: [","],
		placeholder: function() {
			jQuery(this).data('placeholder');
		}
	});
}

function update_pomodoro_clipboard (post_stts, loud) {
	//
	if(debug)
		console.log("update_pomodoro_clipboard()");
	console.log("update_pomodoro_clipboard")
	if(loud)
	change_status(txt_update_current_task);
	//
	doing_ajax = true;
	var postcat=getRadioCheckedValue("cat_vl");
	var privornot=getRadioCheckedValue("priv_vl");
	var data = {
		action: 'update_session',
		post_titulo: title_box.value,
		post_descri: description_box.value,
		post_tags: jQuery('#tags_box').val(),
		post_cat: postcat,
		post_id: post_id_box.value,
		//post_data: data_box.value,
		post_priv: privornot,
		range_volume: jQuery('#rangeVolume').val(),
		soundfx_enabled: jQuery('#soundfx_enabled').prop("checked"),
		voice_enabled: jQuery('#voice_enabled').prop("checked"),
	};
	
	if(interval_clock) {
		//alert(interval_clock);
		data["interval_clock"]=true;
	}
	
	if(post_stts) {
		data["post_status"] = post_stts;
	}

	volumeLevel = jQuery("#rangeVolume").val();
	//soundManager.volume(volumeLevel);
	//pomodoro_completed_sound.volume = volumeLevel;
	//active_sound.volume = volumeLevel;
	//session_reseted_sound.volume = volumeLevel;
	if(artyom_voice!=undefined && volumeLevel>1)
		artyom_voice.initialize({volume:volumeLevel/100});
	//artyom_voice.volume = volumeLevel/100;

	jQuery.post(ajaxurl, data, function(response) {
		doing_ajax = false;
		if(response=="NOTIN")window.location.href = "/";
		//rex = response.split("$^$ ");
		change_status("Pomodoro atualizado");
		//alert(response['ID']);
		// status_box.value = rex[1];
		// data_box.value = rex[2].slice(0, -1);
		//title_box.value = rex[0];
		//tags_box.value  = rex[1];
		//description_box.value = rex[2];
	});
}

//Only one button trigger all actions for timmer manager
function action_button() {
	if(debug)
		console.log("action_button()");
	//2024 as vezes para...
	start_listen_changes_on_task_form();

	if(interval_clock) {
		//The user clicked on Interrupt button 	-> Check if the timmer (countdown_clock()) are running
		interrupt();
	} else {
		//The user clicked on Pomodoro or Rest button
		start_clock();
	}
	startNoSleepWakeLock();
	//startContinuousArtyom();//BROKES SLOW DEVICES
	//update_pomodoro_clipboard();//Isso sim é a verdadeira gambiarra, aplicada ao nível extremo, como não salva a data quando usa "pending", então salva um rascunho com a data de agora e altera para pending que não mexe na data

}
//Start countdown
function start_clock() {
	if(debug)
		console.log("start_clock()");
	if(jQuery("#soundfx_enabled").is(":checked"))
	active_sound.play();
	//TODO: post_status="future;"
	//interval_clock = setInterval('countdown_clock()', intervalMiliseconds);
	//var tempTimer = 0;
	startedTimer = Date.now();
	//tempoCotagem = secondsRemaining;
	interval_clock = setInterval(countdown_clock, 1000)

	//is_pomodoros is when using 25min for focusing
	if(is_pomodoro) {
		change_button(textInterruptFocus, color_focus);//Chage button to "Interrupt Focus"
		//update_pomodoro_clipboard("pending");
		tagsv = jQuery("#tags_box").val().toString().replace(/,/g, ', ');
		change_status(txt_started_countdown + jQuery("#title_box").val() + ", tags " + tagsv);
		//não perde mais tempo perdido - window.onbeforeunload = myConfirmation;
		
		if(status_box.value=="draft")
			save_progress("future");//futuro = true
	} else {
		change_button(textInterruptRest, color_rest);//Chage button to "Stop Rest"
		change_status(txt_rest_started);
		
		//window.onbeforeunload = null;
	}
	//startContinuousArtyom();
}

// function myConfirmation() {
//     return 'Are you sure you want to quit? You have time left on timer';
// }

//Function called every second when pomodoros are running
function countdown_clock (){
	//tempTimer = Math.floor((Date.now() - startedTimer) / 1000);
	//alert(tempTimer);
	//Everty second of pomodoros running these functions are called
	secondsRemaining--;
	//tempoCotagem = secondsRemaining - tempTimer;
	//Function user to convert number, like 140, into clock time, like 2:20
	convertSeconds(secondsRemaining);
	//Functions to make the effect of flip on countdown_clock
	flip_number();
	//Test the end of the time
	if(secondsRemaining<=0)
	complete();
	//Change the title to time
	changeTitle();
	//
	document.getElementById("secondsRemaining_box").value=secondsRemaining + "s";
}


//This is the reason of all the code, the time when user complete a pomodoro, these satisfaction!
function complete() {
	if(debug)
		console.log("complete()");
	//alert("complete(), is_pomodoro: "+is_pomodoro+", pomodoro_actual:"+pomodoro_actual);
	//is_interrupt_button = false;
	pomodoro_completed_sound.pause();
	if(jQuery("#soundfx_enabled").is(":checked"))
	pomodoro_completed_sound.play();
	//
	window.onbeforeunload = null;
	//update_pomodoro_clipboard();//pensei que podia ser EXCESSIVAMENTE
	stop_clock();	
	//changeTitle(txt_title_done);
	if(is_pomodoro) {
		//console.log("is_pomodoro: "+is_pomodoro+", pomodoro_actual:"+pomodoro_actual);
		turn_on_pomodoro_indicator(pomodoro_actual);
		save_progress("publish");
		is_pomodoro = false;
		if(pomodoro_actual==pomodoros_to_big_rest) {
			//big rest
			pomodoro_actual=1;
			change_button(textBigRest, color_default);
			change_status(txt_bigrest_countdown);
			secondsRemaining=bigRestTime;
			changeTitle(txt_title_big_rest);
			reset_indicators_display();
		} else {
			//normal rest
			pomodoro_actual++;
			change_button(textRest, color_default);
			change_status(txt_normalrest_countdown);
			secondsRemaining=restTime;
			changeTitle(txt_title_rest);
		}
		//
		if(autoCycle) {
			cycle_list_next();
		}
	} else {
		//rest finished
		//alert("rest finished")
		change_button(textPomodoro, color_default);
		change_status(txt_completed_rest, "er");
		is_pomodoro=true;
		secondsRemaining=pomodoroTime;
		changeTitle(txt_title_done);
	}
	convertSeconds(secondsRemaining);
	flip_number();
	if(autoAction)
		action_button();
}


//Just stop de contdown_clock function at certains moments
function stop_clock() {
	if(debug)
		console.log("stop_clock()");
	window.clearInterval(interval_clock);
	//pomodoro_completed_sound.play();
	interval_clock=false;
	//update_pomodoro_clipboard();
	//alert(is_pomodoro);
	//Functions to make the effect of flip on countdown_clock
	if(is_pomodoro) {
		convertSeconds(restTime);
	} else {
		convertSeconds(pomodoroTime);
	}
	flip_number(true);
	document.getElementById("secondsRemaining_box").value=pomodoroTime+"s";//pomodoroTime
	//is_interrupt_button = false;
}

//Function to show status warnings at bottom of the clock
function change_status(txt, stts) {
	//console.log("change_status: " + txt);
	if(artyom_voice) {
		artyom_voice.shutUp();
		//artyom_voice.initialize({volume:0.1});
		if(volumeLevel>1 && jQuery("#voice_enabled").is(":checked"))
		artyom_voice.say(txt, {onStart() {window.artyom_voice.dontObey();},onEnd() {window.artyom_voice.obey();}});
	}
	
	if(typeof stts=="undefined")
		alertify.log(txt);
	else if(stts=="suc")
		alertify.success(txt);
	else if(stts=="er")
		alertify.error(txt);

	//document.getElementById("div_status").innerHTML=txt;
}

//Function to change button text and color
function change_button (valueset, colorset) {
	var button = jQuery("#action_button_id");
	//var banner = jQuery(".navbar");
	//var banner = jQuery(".navbar");
	//var banner = jQuery("#main-cotainer");
	
	//var button = document.getElementById("action_button_id");
	button.val(valueset);
	//button.animate({'background-color': colorset}, 2000);
	jQuery("#action_button_id").animate({'background-color': colorset}, 2000);
	//button.set('morph', {duration: 2000});
	//button.morph({/*'border': '2px solid #F00',*/'background-color': colorset});
}

//
function interrupt() {
	if(debug)
		console.log("interrupt()");
	//pomodoro_completed_sound.play();
	//document.getElementById("secondsRemaining_box").value = "";
	//if(!is_pomodoro)is_pomodoro=true;
	
	if(is_pomodoro && status_box.value=="future") {
	 	var sure = confirm(txt_interrupted_ask);
	 	if(!sure)
	 		return;	
	}
	window.onbeforeunload = "";
	
	pomodoro_completed_sound.play();//STARTS FOWARD
	//if(is_pomodoro)is_pomodoro=false;//NAO
	is_pomodoro=true;//SEMPRE QUE INTERROMPER VOLTA PARA FOCAR, CERTO?
	//
	change_status(txt_interrupted_countdowns, "er");
	//convertSeconds(0);
	//flip_number();
	change_button(textPomodoro, color_default);
	//update_pomodoro_clipboard("trash");
	//
	stop_clock();
	//secondsRemaining=0;
	secondsRemaining = pomodoroTime;
	convertSeconds(secondsRemaining); //ALWASY 25 MIN WHEN INTERRUPT
	flip_number(secondsRemaining);
	if(status_box.value=="future") {
		//se estiver future está rolando o tempo, manda um sinal para salvar post futuro e na API vai bater que já tem e vai deletar
		save_progress("interrupt");
	}
	//alert(pomodoroTime);
	//is_interrupt_button=false;
	//if(!is_pomodoro)is_pomodoro=true;
}

//Auxiliar function to countdown_clock() function
function convertSeconds(secs) {
	minutes=secs/60;
	
	if(minutes>10) {
		someValueString = '' + minutes;
		someValueParts = someValueString.split('');
		m1 = parseFloat(someValueParts[0]);
		m2 = parseFloat(someValueParts[1]);
	} else {
		m1 = parseFloat(0);
		m2 = parseFloat(minutes);
	}
	//seconds%=secs/60;
	if(secs%60!=0) {
		seconds=secs%60;
		otherValueString = '' + seconds;
		otherValueParts = otherValueString.split('');
		if(seconds>10) {
			s1 = parseFloat(otherValueParts[0]);
			s2 = parseFloat(otherValueParts[1]);
		} else {
			s1=0;
			s2=parseFloat(otherValueParts[0]);
		}
	} else {
		s1=0;
		s2=0;
	}
	//alert(m1+""+m2+":"+s1+""+s2);
}

function reset_pomodoro_session() {
	if(debug)
		console.log("reset_pomodoro_session()");
	//zerar_pomodoro()
	interrupt();
	pomodoro_actual=1;
	change_status(txt_session_reseted);
	if(jQuery("#soundfx_enabled").is(":checked"))
	session_reseted_sound.play();
	reset_indicators_display();
	//changeTitle("Sessão de pomodoros reiniciada...");
}

function set_continuous_session() {
	if(autoAction) {
		autoAction=false;
		change_status(auto_action_disabled);
		jQuery("#resetter_btn").css("background-color", "transparent");
		jQuery("#resetter_btn").css("color", "#B8B8B8");
	} else {
		autoAction=true;
		change_status(auto_action_enabled);
		jQuery("#resetter_btn").css("background-color", "#FFF");
		jQuery("#resetter_btn").css("color", "#222");
	}
}

//Function to "light" one pomodoro
function turn_on_pomodoro_indicator (indicator_number) {
	//var pomo = ;
	//console.log("turn_on_pomodoro_indicator:"+indicator_number);
	jQuery("#pomoindi"+indicator_number).animate({'background-position': '-30px'});
}

//Function to restart the pomodoros
function reset_indicators_display() {
	jQuery("#pomoindi1").animate({'background-position': '0px'});
	jQuery("#pomoindi2").animate({'background-position': '0px'});
	jQuery("#pomoindi3").animate({'background-position': '0px'});
	jQuery("#pomoindi4").animate({'background-position': '0px'});
}

//Functions to make the effect on the clock
function flip_number(force) {

    const upRight   = pomodorosData.themeUrl + '/pomodoro/Double/Up/Right/';
    const downRight = pomodorosData.themeUrl + '/pomodoro/Double/Down/Right/';
    const upLeft    = pomodorosData.themeUrl + '/pomodoro/Double/Up/Left/';
    const downLeft  = pomodorosData.themeUrl + '/pomodoro/Double/Down/Left/';

    if (m2 != m2_current || force) {
        flip('minutesUpRight', 'minutesDownRight', m2, upRight, downRight);
        m2_current = m2;
    }

    if (m1 != m1_current || force) {
        flip('minutesUpLeft', 'minutesDownLeft', m1, upLeft, downLeft);
        m1_current = m1;
    }

    if (s2 != s2_current || force) {
        flip('secondsUpRight', 'secondsDownRight', s2, upRight, downRight);
        s2_current = s2;
    }

    if (s1 != s1_current || force) {
        flip('secondsUpLeft', 'secondsDownLeft', s1, upLeft, downLeft);
        s1_current = s1;
    }
}

// function flip_number(force) {
// 	/*if(force) {
// 		var m1_current = 9;
// 		var m2_current = 9;
// 		var s1_current = 9;
// 		var s2_current = 9;
// 	}*/
// 	//alert(m1 + " cur:" + m1_current);
// 	if( m2 != m2_current || force){
// 		flip('minutesUpRight', 'minutesDownRight', m2, 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Up/Right/', 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Down/Right/');
// 		m2_current = m2;
// 	}
// 	if( m1 != m1_current || force){	
// 		flip('minutesUpLeft', 'minutesDownLeft', m1, 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Up/Left/', 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Down/Left/');
// 		m1_current = m1;
// 	}
// 	if (s2 != s2_current || force){
// 		flip('secondsUpRight', 'secondsDownRight', s2, 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Up/Right/', 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Down/Right/');
// 		s2_current = s2;
// 	}
// 	if (s1 != s1_current || force){
// 		flip('secondsUpLeft', 'secondsDownLeft', s1, 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Up/Left/', 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Down/Left/');
// 		s1_current = s1;
// 	}
// }

function flip (upperId, lowerId, changeNumber, pathUpper, pathLower){
	//var upperBackId = upperId+"Back";

	var upperBackId = jQuery("#"+upperId+"Back");
	var upperId     = jQuery("#"+upperId);
	var lowerBackId = jQuery("#"+lowerId+"Back");
	var lowerId     = jQuery("#"+lowerId);

	upperId.css("height", "64px");
	upperId.attr("src", upperBackId.attr("src"));
	upperBackId.attr("src", pathUpper+parseInt(changeNumber)+".png");
	upperId.animate({"height": "0"});
	
	lowerId.css("height", "64px");
	lowerId.attr("src", lowerBackId.attr("src"));
	lowerBackId.attr("src", pathLower+parseInt(changeNumber)+".png");
	lowerId.css("margin-top", "0");
	lowerId.animate({"height": "0", "margin-top": "50px"});
	//lowerId.animate({});
	
	//lowerId.animate({height:20, "top:64px", marginTop:0},200)
	//lowerId.animate({top: '-=1px'});

	//jQuery(lowerId).src = pathLower+parseInt(changeNumber)+".png";
	//jQuery(lowerId).css("height", "0px");
	//jQuery(lowerId).css("visibility", "visible");


	//upperBackId.animate({"height": "64px"});

	//upperId.animate({"visibility": "hidden"});
	//upperBackId.animate({"visibility": "visible"});
	/*var flipUpper = new Fx.Tween(upperId, {duration: 200, transition: Fx.Transitions.Sine.easeInOut});
	flipUpper.addEvents({
		'complete': function(){
			var flipLower = new Fx.Tween(lowerId, {duration: 200, transition: Fx.Transitions.Sine.easeInOut});
				flipLower.addEvents({
					'complete': function(){	
						lowerBackId = lowerId+"Back";
						jQuery(lowerBackId).src = jQuery(lowerId).src;
						jQuery(lowerId).css("visibility", "hidden");
						jQuery(upperId).css("visibility", "hidden");
					}				});					
				flipLower.start('height', 64);
				
		}
	});
	flipUpper.start('height', 0);*/
}

//The real life at pomodoros: jQuery calling php function on functions.php
function save_progress(acao) {
	if(debug)
		console.log("save_progress("+acao+")");
	//2024 CAIU?
	var postcat=getRadioCheckedValue("cat_vl");
	var privornot=getRadioCheckedValue("priv_vl");
	//TODO: verificar se o último post publicado já faz mais que pomodoroTime (25min), evitando flood e 2 navegadores abertos
	var data = {
		action: 'save_progress',
		post_acao: acao,
		post_titulo: title_box.value,
		post_descri: description_box.value,
		post_tags: jQuery("#tags_box").val(),
		post_cat: postcat,
		post_priv: privornot,
		post_local_city: jQuery("#user_location_city").text(),
		post_local_region: jQuery("#user_location_region").text(),
		post_local_country: jQuery("#user_location_country").text(),
	};

	jQuery.post(ajaxurl, data, function(response) {
		if(response=="NOTIN")window.location.href = "/";
		if(response)		
		change_status(txt_save_success, "suc");
		else
		change_status(txt_save_error, "er");
		/*Append the fresh completed pomodoro at the end of the list, simulating the data
		var d=new Date();
		data = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+" "+d.getUTCHours()+":"+d.getUTCMinutes()+":"+d.getUTCSeconds();//new Date(year, month, day, hours, minutes, seconds);
		if(response[0]=="1")
		jQuery("#points_completed").append('<li>'+data+" -> "+description.value+'</li>');*/
	});
}

//Load e save user cycle
function cycle_list_update(clean_) {
	content = jQuery("#contem-ciclo").html();
	var data = {
		action: 'update_cycle_list',
		list: content,
		clean: clean_,
	}
	if(clean_) {
		alertify.log("Cleaning list...");
	}
	jQuery.post(ajaxurl, data, function(response) {
		if(clean_) {
			if(response) {
				alertify.log("Cycle list cleared");
				jQuery("#contem-ciclo").html("");
			}
		} else {
			if(response)
				alertify.log("updating cycle list");
			else
				alertify.error("Not updated cycle list");	
		}
	});
}

function cycle_list_play() {
	if(debug)
		console.log("cycle_start(), autoCycle!="+autoCycle);

	if(autoCycle) {
		//THEN PAUSE
		//jQuery("#pomopainel").show(2000);
		//
		autoCycle=false;
		//jQuery("#pomopainel").hide(2000);
		change_status(auto_cycle_disabled);
		//
		//cycle_list_load_model();
		//
		jQuery("#cycle_start").html('<span class="fas fa-play" aria-hidden="true"></span>');//play
		jQuery("#cycle_start").css("background-color", "#CCC");
		jQuery("#cycle_start").css("color", "#222");
		//
		jQuery("#contem-ciclo li").each(function(i){
			jQuery(this).animate({'background-color': "#FFF", "color" : "#000"}, 500);
		});
	} else {
		if(!jQuery("#contem-ciclo li").length) {
			change_status("You must add at least one task", "er");//todo: translate
			return;
		}

		//THE START (play)
		//jQuery("#pomopainel").hide(2000);
		//
		autoCycle=true;
		//jQuery("#pomopainel").show(2000);
		change_status(auto_cycle_enabled);
		jQuery("#cycle_start").html('<span class="fas fa-stop" aria-hidden="true"></span>');
		jQuery("#cycle_start").css("background-color", "#222");
		jQuery("#cycle_start").css("color", "#CCC");
		//
		cycle_list_load_model();
	}
	//jQuery("#contem-ciclo")
}

function cycle_list_load_model() {
	//
	//jQuery("#current_cycle").val(autoCycleCurrent);
	//cycle_list_update();
	//
	current_model_id = jQuery("#contem-ciclo li:nth-child("+autoCycleCurrent+")").find("div").data("modelid");
	//jQuery("#contem-ciclo li").each("li").animate({'background-color': "#FFF"}, 2000);
	jQuery("#contem-ciclo li").each(function(i){
		//if(i!=autoCycleCurrent)
		jQuery(this).removeClass('cycleSelectedTask');
		jQuery(this).animate({'background-color': "#FFF", "color" : "#000"}, 200);
	});
	jQuery("#contem-ciclo li:nth-child("+autoCycleCurrent+")").addClass('cycleSelectedTask', 1000, "easeOutBounce");
	jQuery("#contem-ciclo li:nth-child("+autoCycleCurrent+")").animate({'background-color': "#222",'color': "#CCC"}, 300);//green 5cb85c
	
	//jQuery("#contem-ciclo li:nth-child("+autoCycleCurrent+")").animate({'color': "#CCC"}, 200);
	//autoCyclePrevious = autoCycleCurrent-1;
	//jQuery("#contem-ciclo li:nth-child("+autoCyclePrevious+")").animate({'background-color': "#FFF"}, 2000);
	//autoCycleCurrent 
	load_model(current_model_id);
}

function cycle_list_next() {
	if(debug)
	console.log("cycle_list_next()");
	qtdd_tasks = jQuery('ul#contem-ciclo li').length;
	if(qtdd_tasks==autoCycleCurrent)
		autoCycleCurrent=1;
	else
		autoCycleCurrent++;
	cycle_list_load_model();
}

function cycle_list_prev() {
	qtdd_tasks = jQuery('ul#contem-ciclo li').length;
	if(autoCycleCurrent<=1)
		autoCycleCurrent=qtdd_tasks;
	else
		autoCycleCurrent--;
	cycle_list_load_model();
}
//Load e Save model function
function save_model() {
	change_status(txt_salving_model);
	var data = {
		action: 'save_or_delete_model',
		post_titulo: title_box.value,
		post_descri: description_box.value,
		post_tags: jQuery("#tags_box").val()
	};
	jQuery.post(ajaxurl, data, function(response) {
		if(response=="NOTIN")window.location.href = "/";
		if(response) {
			if(response==0) {
				change_status(txt_salving_model_task_null);
			} else {
				var sessao_atual=parseInt(response);
				valinsert = data.post_tags.toString().split(",").join(', ');
				//valinsert = data.post_tags;
				//primeiro salva o post, para depois pegar o id do mesmo title_box
				htmlTaskModel = ' \
					<li id="modelo-carregado-'+sessao_atual+'" class="modelo-carregado ui-draggable ui-draggable-handle"> \
						<div class="model-container" data-modelid="'+sessao_atual+'"> \
							<div class="col-xs-6"> \
							<span class="fas fa-move" aria-hidden="true"></span> &nbsp; \
							<span id="bxtitle'+sessao_atual+'">'+title_box.value+'</span> \
							</div> \
							<div class="col-xs-6"> \
							<span class="fas fa-tags" aria-hidden="true"></span> &nbsp; \
							<span id="bxtag'+sessao_atual+'">'+valinsert+' </span> \
							</div> \
						</div> \
						<div class="model-container-extra"><button class="btn btn-xs btn-success delete-task-model-btn" data-modelid="40683"><span class="fas fa-trash" style="color:black"></span></button><button" class="btn btn-xs btn-none remove-task-from-list-btn" data-modelid="40683"><span class="fas fa-trash"></span></button"></div> \
					</li>';
					
					/*<p> \
							<span id="bxcontent'+sessao_atual+'">'+description_box.value+'</span> \
							</p> \*/
				jQuery("#contem-modelos").append(htmlTaskModel);
				/*jQuery("#botao-salvar-modelo").val("sessão salvada com sucesso");
				jQuery("#botao-salvar-modelo").attr('disabled', 'disabled');*/
				//document.getElementById("bxcontent"+sessao_atual).focus();
				model_task_buttons_functions();
				change_status(txt_salving_model_success);
			}
		}
		else
		change_status(txt_save_error);
	});
}

function delete_model(task_model_id) {
	//PHP deletar post task_model_id
	//Query("#modelo-carregado-"+task_model_id).css("background-color", "#222");
	jQuery("#modelo-carregado-"+task_model_id).hide(1000);
	change_status(txt_deleting_model);
	var data = {
		action: 'save_or_delete_model',
		post_para_deletar: task_model_id
	};
	jQuery.post(ajaxurl, data, function(response) {
		if(response=="NOTIN")window.location.href = "/";
		if(response) {
			change_status(txt_deleting_model_sucess);
			//jQuery("#modelo-carregado-"+task_model_id).remove();
		} else {
			change_status(txt_save_error);
		}
	});
}

function load_model(task_model_id) {
	if(debug)
		console.log("load_model(), task_model_id"+task_model_id);
	
	change_status(txt_loading_model);
	
	jQuery("#title_box").val(jQuery("#bxtitle"+task_model_id).text());
	jQuery("#description_box").val(jQuery("#bxcontent"+task_model_id).text());
	tags_value = jQuery("#bxtag"+task_model_id).text();
	//a.lert(tags_value);
	valinsert_item = tags_value.split(", ");

	//valinsert = "["+jQuery("#bxtag"+task_model_id).text()+"]";
	valinsert = "[";
	//valinsert = "";
	i=1;
	c=valinsert_item.length;
	valinsert_item.forEach(function(item) {
		if(i<c)
			valinsert += "\'"+item.replace(/ /g,'')+"\',";
		else
			valinsert += "\'"+item.replace(/ /g,'')+"\'";
		i++;
	});
	valinsert += "]";
	//valinsert = "['musica', 'teste', 'pomodoros-2']";
	//alert(valinsert);
	var has_previous_tags = jQuery("#bxtag"+task_model_id);
	//alert(has_previous_tags);
	if(has_previous_tags) {
		jQuery("#tags_box").val(null);//.trigger('change');
		jQuery("#tags_box").val(null);
		jQuery("#tags_box").val(null);
		//jQuery("#tags_box").empty();
		jQuery("#tags_box").val(eval(valinsert)).trigger('change');
		//jQuery("#tags_box").val(["itapemapa", "franciscomat"]).trigger('change');;
		//jQuery("#tags_box").value(jQuery("#bxtag"+task_model_id).text());
	} else {
		//jQuery("#tags_box").empty();
		jQuery("#tags_box").val("").trigger('change');
		//jQuery("#tags_box").value("");
	}
	//jQuery("#tags_box").val(['contabilidade', ]).trigger('change');
	//jQuery("#action_button_id").focus();
}

//Change the <title> of the document
function changeTitle (newtit) {
	if(!newtit) {
		var task_name = document.getElementById('title_box');
		secondsToClock();
		document.title = secondsRemainingClockFormat + " - " + task_name.value;
	} else {
		document.title = newtit;
	}
}
function secondsToClock(secs) {
	secondsRemainingClockFormat = new Date(secondsRemaining * 1000).toISOString().substring(14, 19)
}

function getRadioCheckedValue(radio_name){
   var oRadio = document.forms["pomopainel"].elements[radio_name];
	//alert(oRadio.length);
   for(var i = 0; i < oRadio.length; i++)
   {
      if(oRadio[i].checked)
      {
         return oRadio[i].value;
      }
   }
   return '';
}


//Sound configuration
function startSoundMan() {
	console.log("startSoundMan()");
	/*soundManager.url = 'https://www.pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/assets/soundmanager2.swf';
	soundManager.preferFlash = false;
	soundManager.useHTML5Audio = true;
	soundManager.onready(function() {
		console.log("soundManager.onready()");
		// Ready to use; soundManager.createSound() etc. can now be called.
		active_sound = soundManager.createSound({id: 'mySound2',url: 'https://www.pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/crank-2.mp3',});
		//active_sound = soundManager.createSound({id: 'mySound2',url: 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/77711__sorohanro__solo-trumpet-06in-f-90bpm.mp3',});
		pomodoro_completed_sound = soundManager.createSound({id:'mySound3',url: 'https://www.pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/23193__kaponja__10trump-tel.mp3',});
		session_reseted_sound = soundManager.createSound({id:'mySound4',url: 'https://www.pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/magic-chime-02.mp3',});
	});
	//soundManager.volume(volumeLevel);
	soundManager.onerror = function() {alert(txt_sound_error+"...");}*/
	active_sound = document.getElementById('active_sound').play();
	pomodoro_completed_sound = document.getElementById('pomodoro_completed_sound').play();
	session_reseted_sound =  document.getElementById('session_reseted_sound').play();
}
//
var grupoDeComandos = [{
	    indexes:["iniciar", "focar", "começar", "interromper"], // These spoken words will trigger the execution of the command
	    action:function(){ // Action to be executed when a index match with spoken word
	        artyom_voice.say("Pois não");//era: comando recebido
	        action_button();
	    }
	},
];

var groupOfCommands = [{
	    indexes:["start", "focus", "begin", "interrupt", "stop"], // These spoken words will trigger the execution of the command
	    action:function(){ // Action to be executed when a index match with spoken word
	        artyom_voice.say("Ok");
	        action_button();
	    }
	},
];

var groupSwith = [{
    // note that if you're in spanish for example
    // the command should be instead : "Iniciar en ingles, Iniciar en alemán" etc...
    indexes:["switch to english","switch to portuguese","switch to spanish","switch to french","switch to chinese"],
    action: function(i){
        switch(i){
            case 0: start("en-US"); break;
            case 1: start("pt-PT"); break;
            case 2: start("es-ES"); break;
            case 2: start("fr-FR"); break;
            case 2: start("CN"); break;
        }
    }
}];

// This function activates artyom and will listen all that you say forever (requires https conection, otherwise a dialog will request if you allow the use of the microphone)
function startContinuousArtyom(){
	if (typeof Artyom != "undefined") {
		artyom_voice = new Artyom();
		//
	    artyom_voice.fatality();// use this to stop any of
	    //
	    //a.lert(data_from_php.php_locale);
	    if(data_from_php.php_locale=="pt_BR" || data_from_php.php_locale=="pt") {
	    	gcommands = grupoDeComandos;
	    	artyom_lang = "pt-PT";
	    } else if(data_from_php.php_locale=="es_ES" || data_from_php.php_locale=="es") {
	    	gcommands = groupOfCommands;
	    	artyom_lang = "es-ES";
	    } else if(data_from_php.php_locale=="fr_FR" || data_from_php.php_locale=="fr") {
	    	gcommands = groupOfCommands;
	    	artyom_lang = "fr-FR";
	    } else if(data_from_php.php_locale=="zh_CN" || data_from_php.php_locale=="zh") {
	    	gcommands = groupOfCommands;
	    	artyom_lang = "CN";
	    } else {
	    	gcommands = groupOfCommands;
	    	artyom_lang = "en-US";
	    }
	    //console.log("artyom_lang" + artyom_voice.recognizingSupported());
	    //
	    //setTimeout(function(){// if you use artyom.fatality , wait 250 ms to initialize again.
	         artyom_voice.initialize({
	            lang:artyom_lang,// A lot of languages are supported. Read the docs !
	            continuous:true,// Artyom will listen forever
	            listen: artyom_voice.recognizingSupported(), // Start recognizing
	            debug:true, // Show everything in the console
	            speed:1, // talk normally
	            //volume: volumeLevel/100,
	            //volume: 0,
	            //name: "pomodoro",
	        }).then(function(){
	            console.log("Artyin ready to work !");
	        });
	    //},250);
	    //
	    //if(data_from_php.php_locale=="pt_BR")
	    	//artyom_voice.addCommands(grupoDeComandos);
	    //else
	    if(artyom_voice.recognizingSupported()) {
		    artyom_voice.addCommands(gcommands);
		    artyom_voice.addCommands(groupSwith);
	    }

	    /*artyom_voice.when("COMMAND_RECOGNITION_END",function(status){
		          startContinuousArtyom();
		   
		});
		artyom_voice.when("SPEECH_SYNTHESIS_END",function(){
		          startContinuousArtyom();
		    
		});*/
	}	
}

function startNoSleepWakeLock() {
	noSleep = new NoSleep();
	function enableNoSleep() {
	  noSleep.enable();
	  document.removeEventListener('touchstart', enableNoSleep, false);
	  document.removeEventListener('click', enableNoSleep, false);
	}
	document.addEventListener('touchstart', enableNoSleep, false);
	document.addEventListener('click', enableNoSleep, false);
}
