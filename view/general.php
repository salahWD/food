<div class="container pt-5">
  <div class="text-center mb-4">
    <div class="img-container">
      <img style="max-width: 120px;" src="<?php echo $configration->logo ?? "https://via.placeholder.com/120/09f/fff";?>" alt="logo" class="img-fluid img-thumbnail rounded-circle mb-4">
      <div class="edit-container">
        <button id="update-img-btn" class="edit-img-btn img-thumbnail"><i class="fa-solid fa-camera"></i></button>
      </div>
    </div>
    <h2 class="title"><?php echo $configration->name;?></h2>
  </div>
  <div class="card info-container text-center">
    <div class="card-body">
      <p class="card-text text-dark mb-4">you can edit your information from here.</p>
      <form class="form" method="POST" action="<?php echo M_PATH . "manage/general";?>" enctype="multipart/form-data">
        <input class="hidden" type="file" name="image" id="update-img-input">
        <div class="form-group">
          <label for="phone">Phone number</label>
          <input
                type="number"
                class="form-control"
                id="phone"
                name="phone"
                placeholder="phone number"
                value="<?php echo isset($configration->number) ? $configration->number: "";?>">
        </div>
        <div class="form-group">
          <label for="whats">Whatsapp</label>
          <input
                type="number"
                class="form-control" 
                id="whats"
                name="whatsapp"
                placeholder="whatsapp number"
                value="<?php echo isset($configration->whatsapp) ? $configration->whatsapp: "";?>">
        </div>
        <div class="form-group">
          <label for="whats-msg">Order massage</label>
          <textarea
                type="number"
                class="form-control"
                id="whats-msg"
                name="msg"
                placeholder="whatsapp order massage"
          ><?php echo isset($configration->order_msg) ? $configration->order_msg: "";?></textarea>
        </div>
        <div class="form-group">
          <label for="address">address</label>
          <input
                type="address"
                class="form-control" 
                id="address"
                name="address"
                placeholder="address"
                value="<?php echo isset($configration->address) ? $configration->address: "";?>">
        </div>
        <div class="form-group">
          <label for="currency">currency</label>
          <select name="currency" id="currency" class="form-control">
            <?php foreach ($currencies as $currency):?>
              <option <?php echo $currency->id == $configration->currency ? "selected": "";?> value="<?php echo $currency->id;?>"><?php echo $currency->icon;?> -- <?php echo $currency->name;?></option>
            <?php endforeach;?>
          </select>
        </div>
        <button data-type="general" type="button" id="send-btn" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>