ALTER TABLE asset_rental ADD is_paid TINYINT(1) DEFAULT 0;
ALTER TABLE asset_rental ADD payment_date DATE;
ALTER TABLE asset_rental ADD payment_amount FLOAT;
