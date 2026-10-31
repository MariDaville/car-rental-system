CREATE DATABASE IF NOT EXISTS car_rental_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE car_rental_db;

-- ==========================================
-- 1. USERS
-- ==========================================

CREATE TABLE users (
    user_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    email VARCHAR(150) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    is_active BOOLEAN NOT NULL DEFAULT TRUE,

    email_verified_at DATETIME NULL,

    last_login_at DATETIME NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;


-- ==========================================
-- 2. ROLES
-- ==========================================

CREATE TABLE roles (
    role_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    role_name VARCHAR(50) NOT NULL UNIQUE,

    description VARCHAR(255) NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB;


-- ==========================================
-- 3. USER ROLES
-- ==========================================

CREATE TABLE user_roles (
    user_id BIGINT UNSIGNED NOT NULL,

    role_id INT UNSIGNED NOT NULL,

    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (user_id, role_id),

    CONSTRAINT fk_user_roles_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_user_roles_role
        FOREIGN KEY (role_id)
        REFERENCES roles(role_id)
        ON DELETE RESTRICT

) ENGINE=InnoDB;


-- ==========================================
-- 4. CUSTOMERS
-- ==========================================

CREATE TABLE customers (
    customer_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT UNSIGNED NOT NULL UNIQUE,

    first_name VARCHAR(100) NOT NULL,

    last_name VARCHAR(100) NOT NULL,

    phone VARCHAR(30) NOT NULL,

    address TEXT NULL,

    date_of_birth DATE NULL,

    drivers_license_number VARCHAR(100) NULL,

    drivers_license_expiry DATE NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_customers_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE RESTRICT

) ENGINE=InnoDB;


-- ==========================================
-- 5. CUSTOMER DOCUMENTS
-- ==========================================

CREATE TABLE customer_documents (
    document_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    customer_id BIGINT UNSIGNED NOT NULL,

    document_type ENUM(
        'drivers_license',
        'passport',
        'national_id',
        'other'
    ) NOT NULL,

    file_path VARCHAR(500) NOT NULL,

    verification_status ENUM(
        'pending',
        'verified',
        'rejected'
    ) NOT NULL DEFAULT 'pending',

    verified_by BIGINT UNSIGNED NULL,

    verified_at DATETIME NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_documents_customer
        FOREIGN KEY (customer_id)
        REFERENCES customers(customer_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_documents_verifier
        FOREIGN KEY (verified_by)
        REFERENCES users(user_id)
        ON DELETE SET NULL

) ENGINE=InnoDB;


-- ==========================================
-- 6. LOCATIONS
-- ==========================================

CREATE TABLE locations (
    location_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    location_name VARCHAR(150) NOT NULL,

    address TEXT NOT NULL,

    city VARCHAR(100) NOT NULL,

    parish VARCHAR(100) NULL,

    country VARCHAR(100) NOT NULL DEFAULT 'Jamaica',

    phone VARCHAR(30) NULL,

    email VARCHAR(150) NULL,

    is_active BOOLEAN NOT NULL DEFAULT TRUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;


-- ==========================================
-- 7. VEHICLE CATEGORIES
-- ==========================================

CREATE TABLE vehicle_categories (
    category_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    category_name VARCHAR(100) NOT NULL UNIQUE,

    description TEXT NULL,

    is_active BOOLEAN NOT NULL DEFAULT TRUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB;


-- ==========================================
-- 8. VEHICLES
-- ==========================================

CREATE TABLE vehicles (
    vehicle_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    category_id INT UNSIGNED NOT NULL,

    home_location_id INT UNSIGNED NOT NULL,

    registration_number VARCHAR(30) NOT NULL UNIQUE,

    vin VARCHAR(50) NULL UNIQUE,

    make VARCHAR(100) NOT NULL,

    model VARCHAR(100) NOT NULL,

    manufacturing_year YEAR NOT NULL,

    color VARCHAR(50) NULL,

    transmission ENUM(
        'automatic',
        'manual'
    ) NOT NULL,

    fuel_type ENUM(
        'petrol',
        'diesel',
        'hybrid',
        'electric',
        'other'
    ) NOT NULL,

    seating_capacity TINYINT UNSIGNED NOT NULL,

    daily_rate DECIMAL(12,2) NOT NULL,

    security_deposit DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    current_odometer INT UNSIGNED NOT NULL DEFAULT 0,

    vehicle_status ENUM(
        'active',
        'maintenance',
        'inactive',
        'retired'
    ) NOT NULL DEFAULT 'active',

    description TEXT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_vehicles_category
        FOREIGN KEY (category_id)
        REFERENCES vehicle_categories(category_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_vehicles_location
        FOREIGN KEY (home_location_id)
        REFERENCES locations(location_id)
        ON DELETE RESTRICT,

    CONSTRAINT chk_vehicle_rate
        CHECK (daily_rate >= 0),

    CONSTRAINT chk_vehicle_deposit
        CHECK (security_deposit >= 0),

    INDEX idx_vehicle_category (category_id),

    INDEX idx_vehicle_status (vehicle_status)

) ENGINE=InnoDB;


-- ==========================================
-- 9. VEHICLE IMAGES
-- ==========================================

CREATE TABLE vehicle_images (
    image_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    vehicle_id BIGINT UNSIGNED NOT NULL,

    image_path VARCHAR(500) NOT NULL,

    is_primary BOOLEAN NOT NULL DEFAULT FALSE,

    display_order INT UNSIGNED NOT NULL DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_vehicle_images_vehicle
        FOREIGN KEY (vehicle_id)
        REFERENCES vehicles(vehicle_id)
        ON DELETE CASCADE,

    INDEX idx_vehicle_images (vehicle_id, display_order)

) ENGINE=InnoDB;


-- ==========================================
-- 10. VEHICLE MAINTENANCE
-- ==========================================

CREATE TABLE vehicle_maintenance (
    maintenance_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    vehicle_id BIGINT UNSIGNED NOT NULL,

    maintenance_type VARCHAR(150) NOT NULL,

    description TEXT NULL,

    scheduled_date DATE NULL,

    completed_date DATE NULL,

    odometer_reading INT UNSIGNED NULL,

    cost DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    maintenance_status ENUM(
        'scheduled',
        'in_progress',
        'completed',
        'cancelled'
    ) NOT NULL DEFAULT 'scheduled',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_maintenance_vehicle
        FOREIGN KEY (vehicle_id)
        REFERENCES vehicles(vehicle_id)
        ON DELETE RESTRICT,

    INDEX idx_maintenance_vehicle (vehicle_id),

    INDEX idx_maintenance_date (scheduled_date)

) ENGINE=InnoDB;



-- ==========================================
-- 11. RESERVATIONS
-- ==========================================

CREATE TABLE reservations (
    reservation_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    booking_reference VARCHAR(30) NOT NULL UNIQUE,

    customer_id BIGINT UNSIGNED NOT NULL,

    vehicle_id BIGINT UNSIGNED NOT NULL,

    pickup_location_id INT UNSIGNED NOT NULL,

    return_location_id INT UNSIGNED NOT NULL,

    pickup_at DATETIME NOT NULL,

    return_at DATETIME NOT NULL,

    approval_mode ENUM(
        'automatic',
        'manual'
    ) NOT NULL DEFAULT 'manual',

    reservation_status ENUM(
        'pending',
        'confirmed',
        'rejected',
        'cancelled',
        'completed',
        'no_show'
    ) NOT NULL DEFAULT 'pending',

    approved_by BIGINT UNSIGNED NULL,

    approved_at DATETIME NULL,

    hold_expires_at DATETIME NULL,

    daily_rate DECIMAL(12,2) NOT NULL,

    rental_days INT UNSIGNED NOT NULL,

    subtotal DECIMAL(12,2) NOT NULL,

    discount_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    tax_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    security_deposit DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    total_amount DECIMAL(12,2) NOT NULL,

    currency_code CHAR(3) NOT NULL DEFAULT 'JMD',

    special_requests TEXT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_reservations_customer
        FOREIGN KEY (customer_id)
        REFERENCES customers(customer_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_reservations_vehicle
        FOREIGN KEY (vehicle_id)
        REFERENCES vehicles(vehicle_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_reservations_pickup
        FOREIGN KEY (pickup_location_id)
        REFERENCES locations(location_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_reservations_return
        FOREIGN KEY (return_location_id)
        REFERENCES locations(location_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_reservations_approver
        FOREIGN KEY (approved_by)
        REFERENCES users(user_id)
        ON DELETE SET NULL,

    CONSTRAINT chk_reservation_dates
        CHECK (return_at > pickup_at),

    CONSTRAINT chk_reservation_amounts
        CHECK (
            daily_rate >= 0
            AND subtotal >= 0
            AND discount_amount >= 0
            AND tax_amount >= 0
            AND security_deposit >= 0
            AND total_amount >= 0
        ),

    INDEX idx_reservation_customer (customer_id),

    INDEX idx_reservation_vehicle_dates (
        vehicle_id,
        pickup_at,
        return_at
    ),

    INDEX idx_reservation_status (reservation_status),

    INDEX idx_reservation_hold (hold_expires_at)

) ENGINE=InnoDB;


-- ==========================================
-- 12. RESERVATION STATUS HISTORY
-- ==========================================

CREATE TABLE reservation_status_history (
    history_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    reservation_id BIGINT UNSIGNED NOT NULL,

    previous_status VARCHAR(30) NULL,

    new_status VARCHAR(30) NOT NULL,

    changed_by BIGINT UNSIGNED NULL,

    change_reason TEXT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_reservation_history
        FOREIGN KEY (reservation_id)
        REFERENCES reservations(reservation_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_reservation_history_user
        FOREIGN KEY (changed_by)
        REFERENCES users(user_id)
        ON DELETE SET NULL,

    INDEX idx_reservation_history (
        reservation_id,
        created_at
    )

) ENGINE=InnoDB;





-- ==========================================
-- 13. PAYMENTS
-- ==========================================

CREATE TABLE payments (
    payment_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    reservation_id BIGINT UNSIGNED NOT NULL,

    payment_reference VARCHAR(50) NOT NULL UNIQUE,

    payment_type ENUM(
        'rental',
        'security_deposit',
        'additional_charge'
    ) NOT NULL DEFAULT 'rental',

    payment_method ENUM(
        'cash',
        'online'
    ) NOT NULL,

    amount DECIMAL(12,2) NOT NULL,

    currency_code CHAR(3) NOT NULL DEFAULT 'JMD',

    payment_status ENUM(
        'pending',
        'completed',
        'failed',
        'partially_refunded',
        'refunded'
    ) NOT NULL DEFAULT 'pending',

    received_by BIGINT UNSIGNED NULL,

    paid_at DATETIME NULL,

    notes TEXT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_payments_reservation
        FOREIGN KEY (reservation_id)
        REFERENCES reservations(reservation_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_payments_receiver
        FOREIGN KEY (received_by)
        REFERENCES users(user_id)
        ON DELETE SET NULL,

    CONSTRAINT chk_payment_amount
        CHECK (amount > 0),

    INDEX idx_payments_reservation (reservation_id),

    INDEX idx_payments_status (payment_status)

) ENGINE=InnoDB;


-- ==========================================
-- 14. PAYMENT TRANSACTIONS
-- ==========================================

CREATE TABLE payment_transactions (
    transaction_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    payment_id BIGINT UNSIGNED NOT NULL,

    payment_gateway VARCHAR(100) NOT NULL,

    provider_reference VARCHAR(150) NULL UNIQUE,

    idempotency_key VARCHAR(100) NULL UNIQUE,

    transaction_status ENUM(
        'initiated',
        'pending',
        'succeeded',
        'failed'
    ) NOT NULL DEFAULT 'initiated',

    amount DECIMAL(12,2) NOT NULL,

    currency_code CHAR(3) NOT NULL DEFAULT 'JMD',

    transaction_metadata JSON NULL,

    processed_at DATETIME NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_transactions_payment
        FOREIGN KEY (payment_id)
        REFERENCES payments(payment_id)
        ON DELETE RESTRICT,

    INDEX idx_transaction_payment (payment_id),

    INDEX idx_transaction_status (transaction_status)

) ENGINE=InnoDB;


-- ==========================================
-- 15. REFUNDS
-- ==========================================

CREATE TABLE refunds (
    refund_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    payment_id BIGINT UNSIGNED NOT NULL,

    refund_reference VARCHAR(50) NOT NULL UNIQUE,

    amount DECIMAL(12,2) NOT NULL,

    reason TEXT NULL,

    refund_status ENUM(
        'requested',
        'processing',
        'completed',
        'failed'
    ) NOT NULL DEFAULT 'requested',

    processed_by BIGINT UNSIGNED NULL,

    processed_at DATETIME NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_refunds_payment
        FOREIGN KEY (payment_id)
        REFERENCES payments(payment_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_refunds_processor
        FOREIGN KEY (processed_by)
        REFERENCES users(user_id)
        ON DELETE SET NULL,

    CONSTRAINT chk_refund_amount
        CHECK (amount > 0),

    INDEX idx_refunds_payment (payment_id)

) ENGINE=InnoDB;


-- ==========================================
-- 16. RENTAL AGREEMENTS
-- ==========================================

CREATE TABLE rental_agreements (
    agreement_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    reservation_id BIGINT UNSIGNED NOT NULL UNIQUE,

    contract_number VARCHAR(50) NOT NULL UNIQUE,

    actual_pickup_at DATETIME NULL,

    actual_return_at DATETIME NULL,

    starting_odometer INT UNSIGNED NULL,

    ending_odometer INT UNSIGNED NULL,

    starting_fuel_level DECIMAL(5,2) NULL,

    ending_fuel_level DECIMAL(5,2) NULL,

    agreement_status ENUM(
        'prepared',
        'active',
        'completed',
        'cancelled'
    ) NOT NULL DEFAULT 'prepared',

    agreement_notes TEXT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_agreement_reservation
        FOREIGN KEY (reservation_id)
        REFERENCES reservations(reservation_id)
        ON DELETE RESTRICT,

    CONSTRAINT chk_agreement_odometer
        CHECK (
            ending_odometer IS NULL
            OR starting_odometer IS NULL
            OR ending_odometer >= starting_odometer
        )

) ENGINE=InnoDB;


-- ==========================================
-- 17. VEHICLE INSPECTIONS
-- ==========================================

CREATE TABLE vehicle_inspections (
    inspection_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    agreement_id BIGINT UNSIGNED NOT NULL,

    inspected_by BIGINT UNSIGNED NULL,

    inspection_type ENUM(
        'pickup',
        'return'
    ) NOT NULL,

    odometer_reading INT UNSIGNED NOT NULL,

    fuel_level DECIMAL(5,2) NULL,

    exterior_condition TEXT NULL,

    interior_condition TEXT NULL,

    damage_notes TEXT NULL,

    additional_notes TEXT NULL,

    inspection_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_inspection_agreement
        FOREIGN KEY (agreement_id)
        REFERENCES rental_agreements(agreement_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_inspection_user
        FOREIGN KEY (inspected_by)
        REFERENCES users(user_id)
        ON DELETE SET NULL,

    INDEX idx_inspection_agreement (agreement_id)

) ENGINE=InnoDB;


-- ==========================================
-- 18. RENTAL EXTENSIONS
-- ==========================================

CREATE TABLE rental_extensions (
    extension_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    agreement_id BIGINT UNSIGNED NOT NULL,

    requested_return_at DATETIME NOT NULL,

    previous_return_at DATETIME NOT NULL,

    additional_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    extension_status ENUM(
        'pending',
        'approved',
        'rejected',
        'cancelled'
    ) NOT NULL DEFAULT 'pending',

    approved_by BIGINT UNSIGNED NULL,

    approved_at DATETIME NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_extension_agreement
        FOREIGN KEY (agreement_id)
        REFERENCES rental_agreements(agreement_id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_extension_approver
        FOREIGN KEY (approved_by)
        REFERENCES users(user_id)
        ON DELETE SET NULL,

    CONSTRAINT chk_extension_amount
        CHECK (additional_amount >= 0),

    INDEX idx_extension_agreement (agreement_id)

) ENGINE=InnoDB;


-- ==========================================
-- 19. AUDIT LOGS
-- ==========================================

CREATE TABLE audit_logs (
    audit_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT UNSIGNED NULL,

    action VARCHAR(100) NOT NULL,

    table_name VARCHAR(100) NULL,

    record_id BIGINT UNSIGNED NULL,

    old_values JSON NULL,

    new_values JSON NULL,

    ip_address VARCHAR(45) NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_audit_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE SET NULL,

    INDEX idx_audit_user (user_id),

    INDEX idx_audit_action (action),

    INDEX idx_audit_created (created_at)

) ENGINE=InnoDB;







-- ==========================================
-- DEFAULT APPLICATION ROLES
-- ==========================================

INSERT INTO roles (role_name, description)
VALUES
('Administrator', 'Full application access'),
('Manager', 'Rental business management'),
('Rental Officer', 'Reservation and rental operations'),
('Customer', 'Customer account access');


-- ==========================================
-- DEFAULT VEHICLE CATEGORIES
-- ==========================================

INSERT INTO vehicle_categories (category_name, description)
VALUES
('Economy', 'Affordable and fuel-efficient vehicles'),
('Compact', 'Small vehicles for everyday use'),
('Sedan', 'Standard passenger sedans'),
('SUV', 'Sport utility vehicles'),
('Luxury', 'Premium rental vehicles'),
('Van', 'Passenger and cargo vans');


-- ==========================================
-- INITIAL RENTAL LOCATION
-- ==========================================

INSERT INTO locations (
    location_name,
    address,
    city,
    country,
    is_active
)
VALUES (
    'Main Rental Location',
    'Configure the actual business address',
    'Configure city',
    'Jamaica',
    TRUE
);