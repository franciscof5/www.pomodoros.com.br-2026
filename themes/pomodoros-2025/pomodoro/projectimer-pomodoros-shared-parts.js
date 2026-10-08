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
    indexes:["switch to portuguese","switch to english"],
    action: function(i){
        switch(i){
            case 0: start("pt-PT"); break;
            case 1: start("en-US"); break;
        }
    }
}];

// This function activates artyom and will listen all that you say forever (requires https conection, otherwise a dialog will request if you allow the use of the microphone)
function startContinuousArtyom(){
	artyom_voice = new Artyom();
	//
    artyom_voice.fatality();// use this to stop any of
    //
    //alert(data_from_php.php_locale);
    if(data_from_php.php_locale=="pt_BR")
    	artyom_lang = "pt-PT";
    else
    	artyom_lang = "en-US";
    //
    setTimeout(function(){// if you use artyom.fatality , wait 250 ms to initialize again.
         artyom_voice.initialize({
            lang:artyom_lang,// A lot of languages are supported. Read the docs !
            continuous:true,// Artyom will listen forever
            listen:true, // Start recognizing
            debug:true, // Show everything in the console
            speed:1, // talk normally
            //volume: volumeLevel/100,
            //volume: 0,
            //name: "pomodoro",
        }).then(function(){
            console.log("Ready to work !");
        });
    },250);
    //
    if(data_from_php.php_locale=="pt_BR")
    	artyom_voice.addCommands(grupoDeComandos);
    else
    	artyom_voice.addCommands(groupOfCommands);

    artyom_voice.addCommands(groupSwith);

    /*artyom_voice.when("COMMAND_RECOGNITION_END",function(status){
	          startContinuousArtyom();
	   
	});
	artyom_voice.when("SPEECH_SYNTHESIS_END",function(){
	          startContinuousArtyom();
	    
	});*/
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

