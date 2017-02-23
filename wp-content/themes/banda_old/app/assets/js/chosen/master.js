

jQuery('#ifram_inscription').load(function() {
        // setTimeout(iResize, 50);
        // Safari and Opera need a kick-start.
        // var iSource = document.getElementById('ifram_inscription').src;
        // document.getElementById('ifram_inscription').src = '';
        // document.getElementById('ifram_inscription').src = iSource;
        iResize();
});

jQuery( window ).resize(function() {
        iResize();
});
        


function iResize() {
        console.log('iResize'); 
        document.getElementById('ifram_inscription').style.height = 
        (document.getElementById('ifram_inscription').contentWindow.document.body.offsetHeight + 30) + 'px';
}

