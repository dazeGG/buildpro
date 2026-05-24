<div class="bp-modal" aria-hidden="true" data-modal>
    <div class="bp-modal__overlay" data-modal-close></div>
    <div class="bp-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="bp-modal-title">
        <button class="bp-modal__close" type="button" aria-label="Закрыть" data-modal-close>&times;</button>

        <div class="bp-modal__form" data-modal-form-state>
            <p class="bp-overline">Консультация</p>
            <h2 id="bp-modal-title">Рассчитать стоимость</h2>
            <p>Оставьте контакты — рассчитаем смету бесплатно и&nbsp;без обязательств.</p>

            <form class="bp-lead-form" data-lead-form>
                <label>
                    <span>Ваше имя</span>
                    <input name="name" type="text" placeholder="Иван Петров" required>
                </label>
                <label>
                    <span>Телефон</span>
                    <input name="phone" type="tel" placeholder="+7 (495) 000-00-00" required>
                </label>
                <button class="bp-btn bp-btn--primary bp-btn--form" type="submit">Отправить заявку</button>
                <small>Нажимая кнопку, вы соглашаетесь с&nbsp;обработкой персональных данных</small>
            </form>
        </div>

        <div class="bp-modal__success" data-modal-success-state>
            <div class="bp-modal__success-icon"><?php buildpro_icon('check', 32); ?></div>
            <h2>Заявка отправлена</h2>
            <p>Наш специалист позвонит вам<br>в&nbsp;течение 30&nbsp;минут.</p>
        </div>
    </div>
</div>
