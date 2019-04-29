<div class="modal fade" id="requiredModal" tabindex="-1" role="dialog" aria-labelledby="requiredModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('edit-user-req') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requiredModalLabel">Obvezni Podaci</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="firstname" placeholder="Ime" value="{{ $user['firstname'] }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="lastname" placeholder="Prezime" value="{{ $user['lastname'] }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="email" placeholder="Email" value="{{ $user['email'] }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="telephone" placeholder="Broj mobitela" value="{{ $user['telephone'] }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control" name="address" placeholder="Adresa" value="{{ isset($user['address']->address_1) ? $user['address']->address_1 : '' }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="city" placeholder="Grad" value="{{ isset($user['address']->city) ? $user['address']->city : '' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="postcode" placeholder="Poštanski broj" value="{{ isset($user['address']->postcode) ? $user['address']->postcode : '' }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="date" class="form-control" name="birthday" placeholder="Datum rođenja" value="{{ $user['birthday'] }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="template-contactform-spol">Spol</label>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary btn-lg bluebi">
                                    <input type="radio" name="sex" value="M" {{ ($user['sex'] == 'M') ? 'checked' : '' }}> Muško
                                </label>
                                <label class="btn btn-primary btn-lg bluebi">
                                    <input type="radio" name="sex" value="Ž" {{ ($user['sex'] == 'F') ? 'checked' : '' }}> Žensko
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>