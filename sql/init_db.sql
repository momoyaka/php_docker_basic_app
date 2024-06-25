-- noinspection SqlNoDataSourceInspectionForFile
-- initial sql script
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INTEGER NOT NULL REFERENCES categories(id),
    price NUMERIC(10, 2) NOT NULL
);

CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    product_id INTEGER NOT NULL REFERENCES products(id),
    quantity INTEGER NOT NULL CHECK (quantity > 0),
    purchase_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE statistics (
    id SERIAL PRIMARY KEY,
    category_id INTEGER NOT NULL REFERENCES categories(id),
    date DATE NOT NULL,
    total_quantity INTEGER NOT NULL DEFAULT 0,
    UNIQUE (category_id, date)
);

CREATE OR REPLACE FUNCTION update_statistics() RETURNS TRIGGER AS $$
BEGIN

INSERT INTO statistics (category_id, date, total_quantity)
VALUES (
           (SELECT category_id FROM products WHERE id = NEW.product_id),
           CURRENT_DATE,
           NEW.quantity
       )
    ON CONFLICT (category_id, date) DO
UPDATE SET total_quantity = statistics.total_quantity + EXCLUDED.total_quantity;
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_order_insert
    AFTER INSERT ON orders
    FOR EACH ROW
    EXECUTE FUNCTION update_statistics();
