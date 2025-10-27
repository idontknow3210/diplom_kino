const film = document.querySelector('#film');
const seance = document.querySelector('#seance');
const addFilm = document.querySelector('#addFilm');
const removeFilm = document.querySelector('#removeFilm');
const removeSeance = document.querySelector('#removeSeance');

addFilm.addEventListener('click', () => {
    film.classList.add('active');
});

const confStepSeances = document.querySelector('.conf-step__seances');
const confStepMovies = document.querySelector('.conf-step__movies');
const filmForm = film.querySelector('form');
const fieldSet = confStepMovies.nextElementSibling.nextElementSibling;
function seanceActive() {
    fieldSet.children[0].addEventListener('click', () => {
        seance.classList.add('active');
        seance.querySelectorAll('select').forEach(el => {
            el.innerHTML = ``;
            if (el.name === 'hall') {
                Array.from(halls.children).forEach(elem => {
                    el.innerHTML += `<option>${elem.textContent}</option>`;
                });
            } else {
                Array.from(confStepMovies.querySelectorAll('.conf-step__movie-title')).forEach(elem => {
                    el.innerHTML += `<option>${elem.textContent}</option>`;
                });
            }
        });
    });
};

seanceActive();

filmForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(filmForm);
    const filmInput = [];
    for (let el of formData) {
        filmInput.push(el[1]);
    }
    film.classList.remove('active');
    let img = new Image();
    img.src = URL.createObjectURL(filmInput[4]);
    let infoImage;
    img.onload = function () { infoImage = true };
    img.onerror = function () { infoImage = false };
    if (infoImage) {
        fetch('http://localhost:8000/php/backAdmin.php', {
            method: 'POST',
            body: formData
        }).then(response => {
            if (response.ok) {
                confStepMovies.innerHTML += `<div class="conf-step__movie">
            <img class="conf-step__movie-poster" alt="poster" src="http://localhost:8000/i/posters/${filmInput[4].name}">
            <h3 class="conf-step__movie-title">${filmInput[0]}</h3>
            <p class="conf-step__movie-duration">${filmInput[1]}</p>
          </div>`;
                seanceActive();
                activeDeleteFilm();
                fetch('http://localhost:8000/php/backAdmin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(['films', confStepMovies.innerHTML])
                }).then(res => console.log(res.ok));
                fetch('http://localhost:8001/php/film.php', {
                    method: 'POST',
                    body: formData
                });
            }
        });
    }

});
let startMovie = [];
function selectedSort(arr) {
    for (let i = 0; i < arr.length; i++) {
        let min = i;
        for (let j = i + 1; j < arr.length; j++) {
            let first = arr[min].children[1].textContent.split("");
            let second = arr[j].children[1].textContent.split("");
            first.splice(2, 1);
            second.splice(2, 1);
            if ((+first.join("")) > (+second.join(""))) {
                min = j;
            }
        }
        [arr[i], arr[min]] = [arr[min], arr[i]];
    }
}

const backgroundColors = ['#caff85', '#85ff89', '#85ffd3', '#85e2ff', '#8599ff', '#ba85ff', '#ff85fb', '#ff85b1', '#ffa285'];
function createBackgroundColor(nameFilm) {
    confStepMovies.querySelectorAll('.conf-step__movie-title').forEach((movieTitle, id) => {
        nameFilm.forEach(seanceMovieTitle => {
            if (movieTitle.textContent === seanceMovieTitle.textContent) {
                seanceMovieTitle.parentNode.style.backgroundColor = backgroundColors[id];

            }
        });

    });
}

let typeSeance = null;
let typeFilm = null;
let confStepHalls = document.querySelectorAll('.conf-step__seances-hall');
function activeDeleteSeance(seances) {
    Array.from(seances).forEach(elem => {
        elem.addEventListener('click', () => {
            removeSeance.querySelector('span').textContent = `<<${elem.children[0].textContent}>>`;
            removeSeance.classList.add('active');
            typeSeance = elem;
        });
    });
}


function activeDeleteFilm() {
    Array.from(confStepMovies.children).forEach(elem => {
        elem.addEventListener('click', () => {
            removeFilm.querySelector('span').textContent = `<<${elem.children[1].textContent}>>`;
            removeFilm.classList.add('active');
            typeFilm = elem;
        });
    });
}
activeDeleteFilm();

function deleteFilmSeance(deleteAny, name, namehall = null, time = null, image = null) {
    fetch('http://localhost:8001/php/back.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify([deleteAny, name, namehall, time, image])
    });
}
removeFilm.querySelector('.conf-step__button-accent').addEventListener('click', (e) => {
    e.preventDefault();
    const srcImg = typeFilm.children[0].src.slice(typeFilm.children[0].src.lastIndexOf('/') + 1);
    Array.from(confStepSeances.children).forEach(el => {
        Array.from(el.children[1].children).forEach(elem => {
            if (elem.children[0].textContent === typeFilm.children[1].textContent) {
                elem.remove();
            }
        });
    });
    deleteFilmSeance('deletefilm', typeFilm.children[1].textContent, null, null, srcImg);
    typeFilm.remove();
    confStepHalls = document.querySelectorAll('.conf-step__seances-hall');
    confStepHalls.forEach(el => {
        createBackgroundColor(el.querySelectorAll('.conf-step__seances-movie-title'));
    });
    fetch('http://localhost:8000/php/backAdmin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(['removefilms', confStepMovies.innerHTML, srcImg])
    }).then(res => console.log(res.ok));
    reloadRSeanse();
    removeFilm.classList.remove('active');


});

confStepHalls.forEach(el => {
    activeDeleteSeance(el.children[1].children);
});

function reloadRSeanse() {
    fetch('http://localhost:8000/php/backAdmin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(['seances', hallsSessionGrid.innerHTML])
    });
}

removeSeance.querySelector('.conf-step__button-accent').addEventListener('click', (e) => {
    e.preventDefault();
    deleteFilmSeance('deleteSeance', typeSeance.children[0].textContent, typeSeance.parentNode.previousElementSibling.textContent, typeSeance.children[1].textContent);
    typeSeance.remove();
    removeSeance.classList.remove('active');
    reloadRSeanse();
});

const seanceForm = seance.querySelector('form');
seanceForm.addEventListener('submit', (e) => {
    e.preventDefault();
    confStepHalls = document.querySelectorAll('.conf-step__seances-hall');

    const formData = new FormData(seanceForm);
    const seanceInput = [];
    for (let el of formData) {
        seanceInput.push(el[1]);
    }
    let infoSeanceTime = true;
    confStepHalls.forEach(el => {
        if (el.children[0].textContent === seanceInput[0]) {
            Array.from(el.children[1].children).forEach(elem => {
                if (elem.children[1].textContent === seanceInput[2]) {
                    infoSeanceTime = false;
                }
            });
            if (infoSeanceTime) {
                el.children[1].innerHTML += `<div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 60px;">
                  <p class="conf-step__seances-movie-title">${seanceInput[1]}</p>
                  <p class="conf-step__seances-movie-start">${seanceInput[2]}</p>
                </div>`;
                Array.from(el.children[1].children).forEach(elem => {
                    startMovie.push(elem);
                });
                selectedSort(startMovie);

                el.children[1].innerHTML = ``;

                startMovie.forEach((element) => {
                    el.children[1].innerHTML += `<div class="conf-step__seances-movie" style="width: 60px;">${element.innerHTML}</div>`;
                });

                createBackgroundColor(el.querySelectorAll('.conf-step__seances-movie-title'));
                activeDeleteSeance(el.children[1].children);
            } else {
                alert('В этом зале уже есть такое время!');
            }
        }
        startMovie = [];
        seance.classList.remove('active');
    });
    if (infoSeanceTime) {
        reloadRSeanse();
        fetch('http://localhost:8001/php/film.php', {
            method: 'POST',
            body: formData
        }).then(response => console.log(response.ok));
    }
});