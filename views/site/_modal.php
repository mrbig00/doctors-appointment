<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 *
 * @var $this \yii\web\View
 */
?>
<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel"
     aria-hidden="true">
    <form id="appointment-form">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Add new appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="alert alert-danger" id="error-messages">

                        </div>
                        <div class="form-group">
                            <label for="patientName" class="col-4 col-form-label">Nev</label>
                            <div class="col-8">
                                <input id="patientName" name="patientName" placeholder="Paciens neve" type="text"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dateStart" class="col-4 col-form-label">Datum</label>
                            <div class="col-8">
                                <input id="dateStart" name="dateStart" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="timeStart" class="col-4 col-form-label">Kezdesi ido</label>
                            <div class="col-8">
                                <input id="timeStart" name="timeStart" type="time" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="timeEnd" class="col-4 col-form-label">Befejezesi ido</label>
                            <div class="col-8">
                                <input id="timeEnd" name="timeEnd" type="time" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="repeat" class="col-4 col-form-label">Ismetlodes</label>
                            <div class="col-8">
                                <select id="repeat" name="repeat" class="custom-select form-control">
                                    <option value="none">Nem ismetlodik</option>
                                    <option value="weekly">Hetente ismetlodik</option>
                                    <option value="biWeekly">Kethetente ismetlodik</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="repeat-date-end-container">
                            <label for="dateEnd" class="col-4 col-form-label">Imsetlodes vege</label>
                            <div class="col-8">
                                <input id="dateEnd" name="dateEnd" type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
    </form>
</div>

