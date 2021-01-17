const startLoader = function(element) {
        // check if the element is not specified
        if(typeof element == 'undefined') {
            element = "body";
        }
        // set the wait me loader
        $(element).waitMe({
            effect : 'bounce',
            text : 'Please Wait..',
            bg : 'rgba(255,255,255,0.7)',
            //color : 'rgb(66,35,53)',
            color : '#EFA91F',
            sizeW : '20px',
            sizeH : '20px',
            source : ''
        });
    }
    const stopLoader = function(element) {
        // check if the element is not specified
        if(typeof element == 'undefined') {
            element = 'body';
        }
        // close the loader
        $(element).waitMe("hide");
    }