var ime = "";

onmessage = function( e ) 
{
    if(ime === "") {
        ime = e.data;
    }
    postMessage(
        {
            ime: ime,
            x: 50 + 500 * Math.random(),
            y: 50 + 500 * Math.random(),
            alpha: 2 * Math.PI * Math.random()
        }
    );
    var waitSeconds = Math.floor((Math.random() * 5) + 1);
    setTimeout(onmessage, 1000 * waitSeconds);
};
