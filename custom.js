$ = jQuery;

(function($){
  $(function(){ 
    $('#input_publ_cont').datetimepicker({
      "allowInputToggle": true,
      "showClose": true,
      "showClear": true,
      "showTodayButton": true,
      "format": "MM/DD/YYYY HH:mm:ss",
    });
  
    $('#input_add_cont').datetimepicker({
      "allowInputToggle": true,
      "showClose": true,
      "showClear": true,
      "showTodayButton": true,
      "format": "MM/DD/YYYY HH:mm:ss",
    });
  });

})(jQuery);
function deleteBook(id)
{
  $.get('delete_book.php?id="'+id+'"')
  .then(function(res)
  {
    console.log(res);
  })
  .fail(function(err){
    console.log(err);
  });
  var btn = document.getElementById(id);// u celom dokumentu nadjem id knjige i stavim dugme delete knjige koju brisem
  var row = btn.parentNode.parentNode.parentNode;

  row.parentNode.removeChild(row);
}
function deleteAuthor(id)
{
  $.get('delete_author.php?id="'+id+'"')
  .then(function(res)
  {
    console.log(res);
  })
  .fail(function(err){
    console.log(err);
  });
  var btn = document.getElementById(id);
  var row = btn.parentNode.parentNode.parentNode;

  row.parentNode.removeChild(row);
}
function toggleForm()
{
  if($('.content').hasClass("active"))
    {
      
      $('.content').fadeOut();
      $('.content').removeClass("active");
      
    }else{
      
      $('.content').fadeIn();
      $('.content').addClass("active");
      
    }
}

$( document ).ready(function() {//pripremamo sve elemente na web strani, proveravamo da li su ucitani dugmici, polja itd...
  
  $('.btn-close').click(function()//close dugme na add/edit formi
  {
    $('#add-form')[0].reset();//reset cele forme, praznjenje unetih vrednosti-ugradjena fja reset
  });


  $('#add-form').submit(function(e){ //kada se submituje forma, parametar e cuva sve podatke sa forme
    e.preventDefault(); // sprecava slanje podataka sa forme post metodom skripti add_update_book/author
    let isNew = $(".editable-id").val() === "";
    let form = e.target; //uzima form sa html-a
    let formData = new FormData (form);  //FormData ugradjena u js i sluzi za prikupljanje svih ulaznih podataka    
    let data    = $(this).serializeArray(); //this <=> add-form
    console.log(data);
    //druga primena ajaxa
    $.ajax({
      url: form.action, //action sa forme moze biti add_update_book/author
      data:data,//podaci sa forme serijalizovani
      method: form.method,// POST/GET
      //success ako su gornje tri linije dobre, ako pukne ide u error blok
      success: function(response){//response je odgovor koji predstavlja id knjige/autora koji se dodaje ili update
      var id = response.replace('\r','').replace('\n','');//formatiranje id da bismo procitali
      let tbody  = $('#table-cont'); 
      let str = '';
      let index = 0;

      var allvalues =  formData.values();
      console.log(allvalues);
      for (var value of formData.values()) {
        if(index !== 5) //ako nije polje editableid
        {
           if($("#select-author").length > 0 && index === 2){ //nalazis se na index.php stranici sa knjigama
             let authorName = $("#select-author > option[value='"+ value +"']").text();//vraca izabranog autora, pa moramo da je pretvorimo u tekst
             str += "<td data-author_id='"+value+"'><span>" + authorName + "</span></td>";//polje u tabeli ya ime autora
           }
           else if($("#select-author").length > 0 && ( index == 3 || index ==4))//rad sa datumima, forma na stranici books(index)
           {
            str += "<td><span>" + value.substr(0,10) + "</span></td>";//uzimanje oba datuma published i added on
           }
           else if ($("#select-author").length == 0 && index == 2)//stranica authors.php
           {
            str += "<td><span>" + value.substr(0,10) + "</span></td>";//added on
           }
           else  if ($("#select-author").length == 0 && index == 3)
           {

           }
           else {
            str += "<td><span>" + value + "</span></td>";
          }
          index++;
        }
      }      
      var isBook = $("#select-author").length > 0;
      var btnclass = isBook ? 'delete-book' : '';//delete book postoji samo u index.php
      str+='<td><span><button type="button" data-toggle="modal" data-target="#add_edit_Modal" data-id="'+id+ '" id="' +id+ '" class="btn btn-info edit-book btn-edit editable">Edit</button>  <button id="' +id+ '" class="btn btn-danger btn-delete ' + btnclass + '">Delete</button><span></td>'; 
      if(!isNew)
      {  
        let selectorID = ".tr-";
        selectorID = selectorID.concat(id)
        tbody.find(selectorID).remove();
      }
      
   
      tbody.append("<tr class='tr-"+id+"'>"+str+"</tr>");

        
        $('.editable-id').val('');
        $('.form-group input').each( function(i, elem){
          $(elem).val('');
        });

        
        $('#add_edit_Modal').modal('toggle');
      },
      error : function(err)
      {
        console.log(err);
      }
    });
    return false;
  });
 var isChecked = false;
  $(document).on('click', '.editable', function(e)
  {
    let id = $(this).data('id');//this je editable, id edit dugmeta sa tim idjem
    $('.editable-id').val(id);//vrednos id iz edit dugmeta stavimo u skriveno polje

    $(this).closest('tr').find('td > span').each (function(i,elem) {//u kom redu se nalazi edit dugme, u promenljivoj value pamtimo vrednosti iz svakog polja u tom redu
      let value = $(elem).html().replace(/\s{2,}/g, '').trim();
      console.log(value);
     
      if($("#select-author").length == 0)//na authors stranici
      {
        //for authors.php
        if(i===0)
          $("#firstname").val(value);
        else if(i===1)
          $("#lastname").val(value);        
        else if(i===2)
         $("#insertedOn").val(value); 
      

      }else{
        //for index.php - books
        
        if(i===0)
          $("#caption").val(value);
        else if(i===1)
          $("#genre").val(value);
        else if(i===3)
          $("#publishedOn").val(value); 
        else if(i===4)
          $("#insertedOn").val(value); 
        
           
      }
    });                  
    

  });

  $(document).on('click','.btn-delete', function(e)
  {
    
    if($(this).hasClass('delete-book'))//ako btn-dete pripada klasi delete-book koja ima samo u index.php
      deleteBook($(this).attr('id'));
    else deleteAuthor($(this).attr('id'));
  });
 
  $('.clear-editable').click(function(){
    $('.editable').prop('checked',false);
    $('.editable-id').val('');
    $('.form-group input').each( function(i, elem){
      $(elem).val('');
    });
  });

  $('.collapsible').click(function()
  {
    toggleForm();//da se zatvori forma
    
  });
  

});




