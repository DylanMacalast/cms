$(document).ready(function(){
    //CKEDITOR

    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
    
    //REST OF CODE
$('#selectAllBoxes').click(function(event){
if(this.checked) {
    $('.checkBoxes').each(function(){
        this.checked = true;
    });
} else {
    $('.checkBoxes').each(function(){
        this.checked = false;
    });
}
});

});





    
        
