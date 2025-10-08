const buttonConfChair = confStepAll[1].querySelector('fieldset').children[0];
buttonConfChair.addEventListener('click', () => {
    const typechairs = confStepHall.innerHTML;
    console.log('one')
    Array.from(configurationsHallsPrice[0].children).forEach(el => {

        if (el.querySelector('.conf-step__radio').checked) {
            const numberHall = ['chairs', el.querySelector('.conf-step__radio').value, typechairs];
            fetch('http://localhost:8001/php/back.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(numberHall)
            }).then(response => {
                if (response.ok) {
                    buttonConfChair.nextElementSibling.textContent = numberHall[1] + ': типы и порядок мест изменены!';
                }
            });
        }
    });

});
const buttonConfPrice = confStepAll[2].querySelector('fieldset').children[0];
class PriceHall {
    constructor(vip, standart) {
        this.vip = vip;
        this.standart = standart;
    }
}

buttonConfPrice.addEventListener('click', () => {
    let priceHalls;
    let numberPriceHall = null;
    Array.from(configurationsHallsPrice[1].children).forEach(el => {
        if (el.querySelector('.conf-step__radio').checked) {
            numberPriceHall = el.querySelector('.conf-step__radio').value;
            priceHalls = ['price', numberPriceHall, new PriceHall(confStepAll[2].querySelector('.conf-step__chair_vip').previousElementSibling.children[0].value, confStepAll[2].querySelector('.conf-step__chair_standart').previousElementSibling.children[0].value)];
        }
    });
    if (priceHalls) {
        fetch('http://localhost:8001/php/back.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(priceHalls)
        }).then(response => {
            if (response.ok) {
                buttonConfPrice.nextElementSibling.textContent = numberPriceHall + ': цены изменены!';
            }
        });
    }
});






