window.addEventListener('scroll', function() {
  let header = document.querySelector('header');

  header.classList.toggle('scrolling', window.scrollY > 0);
})


// SLIDER AREA
var counter = 1;
    setInterval(function(){
      document.getElementById('radio' + counter).checked = true;
      counter++;
      if(counter > 4){
        counter = 1;
      }
}, 5000);



const profile = document.getElementById('profile');
var dropDown = document.getElementById('dropdown-nav');

profile.addEventListener('click', function(){

   if(dropDown.style.display === 'none'){
     dropDown.style.display = 'flex';
   } else{
     dropDown.style.display = 'none';
   }

});










