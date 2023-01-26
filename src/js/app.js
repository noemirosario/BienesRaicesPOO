document.addEventListener('DOMContentLoaded', function(){
    eventListeners();
    darkMode();
})

// function darkMode(){
//     const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
//     console.log(prefiereDarkMode.matches)
//     if (prefiereDarkMode.matches) {
//         document.body.classList.add('dark-mode')
//     } else {
//         document.body.classList.remove('dark-mode')
//     }
    
//     prefiereDarkMode.addEventListener('change', function(){
//         if (prefiereDarkMode.matches) {
//             document.body.classList.add('dark-mode')
//         } else {
//             document.body.classList.remove('dark-mode')
//         }
//     })

//     const btnDarkMode = document.querySelector('.btn-dark-mode');
//     btnDarkMode.addEventListener('click', function(){
//         document.body.classList.toggle('dark-mode');

//     })
// }

function eventListeners (){
    const mobilMenu = document.querySelector('.mobil-menu');
    mobilMenu.addEventListener('click', navegacionResposive);

}

function navegacionResposive(){
    const navegacion = document.querySelector('.navegacion');

    // Toggle 
    // El método toggle permite cada vez que se ejecute cambiar de estado la visibilidad del elemento HTML, es decir si está visible pasa a oculto y si se encuentra oculto pasa a visible.

    navegacion.classList.toggle('mostrar')

    // if(navegacion.classList.contains('mostrar')){
    //     navegacion.classList.remove('mostrar')
    // } else {
    //     navegacion.classList.add('mostrar')

    }
