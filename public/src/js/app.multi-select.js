
$(document).ready(function () {
   



$.each( $( "div.ROOTmultiSelectItem button.close"  ), function() {

$(this).click(function (e) {
  $(this).siblings('.ms-container ').toggle(500);
})
}); //close navigation


// daba ha tamar 
//$.each( $( "p" ), function() {
//    // Do something
//});

$.each( $( '.multiSelectItemwassim' ), function() {
    
   


(function($this) {
     $($this).multiSelect(
        {
 
      
 
    afterInit: function(ms){
        
    var that = this;
    var  $selectableSearch = that.$selectableUl.prev(); // input sherch <input  type='search'  class='search-input .....
    var  $selectionSearch = that.$selectionUl.prev();
    var  selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)'; // select par id (id Math.random())
     var selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

    that.qs1 = $selectableSearch.quicksearch(selectableSearchString ).on('keydown', function(e){
      if (e.which === 40){
        
        that.$selectableUl.focus();
    
        return false;
      }
    });
    

    that.qs2 = $selectionSearch.quicksearch(selectionSearchString) .on('keydown', function(e){ 
        if (e.which == 40){
        that.$selectionUl.focus();
        return false;
      }});
  }
  
    ,
  
    afterSelect: function(values){
    this.qs1.cache();
    this.qs2.cache();
    alert("Select value: "+values);
  },
    afterDeselect: function(values){
     this.qs1.cache();
     this.qs2.cache();
    alert("Deselect value: "+values);
  },

  //selectableFooter: "<div class='searchable'>Selectable footer</div>",
  //selectionFooter: "<div class='searchable'>Selection footer</div>",
  selectableHeader: "<input  type='search'  class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
  selectionHeader: "<input type='search'   class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
  dblClick:true,
  cssClass: 'wassim_class'
}
        
        );

})(this);



});



$('#select-all').click(function(){
  $('#public-methods').multiSelect('select_all');
  return false;
});
$('#deselect-all').click(function(){
  $('#public-methods').multiSelect('deselect_all');
  return false;
});
$('#select-100').click(function(){
  $('#public-methods').multiSelect('select', ['elem_3', 'elem_1', 'elem_2']);
  return false;
});
$('#deselect-100').click(function(){
  $('#public-methods').multiSelect('deselect', ['elem_3', 'elem_1', 'elem_2']);
  return false;
});
$('#refresh').on('click', function(){
  $('#public-methods').multiSelect('refresh');
  return false;
});
$('#add-option').on('click', function(){
$('.searchable').multiSelect('addOption', { value: 42, text: 'test 42', index: 0 });
  return false;


});


  $('[data-toggle]').hover(
            function (parameters) {$(this).popover('show') },
            function (parameters) {$(this).popover('hide')}
            ) // pop show 
    
  
    // daba ha tamar 
$.each( $( ".ms-container" ), function() {
    var lisetItem = $(this).find("tbody>tr");
    if(lisetItem[0] != undefined){   
    if (lisetItem[0].innerText==""){
      $(this).hide();
      $(this).parent().css("background-color", "#dcd8d9");
}
    
            }
  });
    
    
    
   
    
    
    })