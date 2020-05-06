<?php
// Notifikasi
if($this->session->flashdata('sukses')) {
    echo '<p class="alert alert-success">';
    echo $this->session->flashdata('sukses');
    echo '</div>';
}
?>

<?php
//Error Upload
if(isset($error)){
    echo'<p class="alert alert-warning">';
    echo $error;
    echo '</p>';
}

// Notifikasi error
echo validation_errors('<div class="alert alert-warning">','</div>');

// Form Open
echo form_open_multipart(base_url('tata_usaha/profile'), 'class="form-horizontal"');
?>

<div class="form-group">
    <label class="col-md-2 control-label">Foto</label>
    <div class="col-md-5">
        <img src="<?php echo base_url('assets/upload/image/'.$profile->foto) ?>" class="img img-responsive img-thumbnail" width="200">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Upload Foto</label>
    <div class="col-md-5">
        <input type="file" name="foto" class="form-control" placeholder="Upload Foto" value="<?php echo $profile->foto ?>" readonly>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Nama Administrasi</label>
    <div class="col-md-5">
        <input type="text" name="nama" class="form-control" placeholder="Nama Administrasi" value="<?php echo $profile->nama_administrasi ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">NIP</label>
    <div class="col-md-5">
        <input type="text" name="nip" class="form-control" placeholder="NIP" value="<?php echo $profile->nip ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Password</label>
    <div class="col-md-5">
        <input type="text" name="password" class="form-control" placeholder="Password" value="<?php echo $profile->password ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Kelamin</label>
    <div class="col-md-5">
        <input type="text" name="kelamin" class="form-control" placeholder="Kelamin" value="<?php echo $profile->kelamin ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Agama</label>
    <div class="col-md-5">
        <input type="text" name="agama" class="form-control" placeholder="Agama" value="<?php echo $profile->agama ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Tempat Lahir</label>
    <div class="col-md-5">
        <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?php echo $profile->tempat_lahir ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Tanggal Lahir</label>
    <div class="col-md-5">
        <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="<?php echo $profile->tanggal_lahir ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Alamat</label>
    <div class="col-md-5">
        <textarea name="alamat" class="form-control" placeholder="Alamat"><?php echo $profile->tempat_lahir ?></textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-5">
        <button class="btn btn-success btn-lg" name="submit" type="submit">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>
</div>

<?php echo form_close(); ?>