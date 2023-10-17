<?php

?>
<div class="new-fields">
    <label for="opportunity_deadline"><?= __( 'Opportunity deadline', 'buddyboss-theme' ) ?></label>
    <input type="number" name="opportunity_deadline" id="opportunity_deadline" min="1" max="99" value="30">
    &nbsp;<?= __( 'days', 'buddyboss-theme' ) ?>
</div>

<div class="new-fields">
    <label for="necessary_professionals"><?= __( 'Necessary professionals', 'buddyboss-theme' ) ?></label>
    <div class="row">
        <div class="col-6">
            <div class="input-group">
                <select class="form-control especialties">
                    <option value="0" disabled>Produção e processo</option>
                    <option value="1" disabled>Pesquisa e desenvolvimento</option>
                    <option value="2">Laboratório</option>
                    <option value="3">Comercial</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-primary">Adicionar</button>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex justify-content-between th">
                <span>Especialidade</span>
                <span>Qtd. Horas</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Produção e processo</span>
                <div class="d-flex align-items-center">
                    <input type="number" name="necessary_professionals_1" id="necessary_professionals_1" min="1" max="99" value="4">
                    <span class="bb-icon bb-icon-close"></span>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <span>Pesquisa e desenvolvimento</span>
                <div class="d-flex align-items-center">
                    <input type="number" name="necessary_professionals_2" id="necessary_professionals_2" min="1" max="99" value="4">
                    <span class="bb-icon bb-icon-close"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="new-fields">
    <label><?= __( 'ODSs involved in the opportunity', 'buddyboss-theme' ) ?></label>
    <input type="checkbox" name="odss_involved_1" id="odss_involved_1">
    &nbsp;
    <label class="check" for="odss_involved_1">
    <?= __( 'Erradicacao da pobreza', 'buddyboss-theme' ) ?>
    </label>
    <br />
    <input type="checkbox" name="odss_involved_1" id="odss_involved_1">
    &nbsp;
    <label class="check" for="odss_involved_1">
    <?= __( 'Fome zero e agricultura sustentavel', 'buddyboss-theme' ) ?>
    </label>
</div>