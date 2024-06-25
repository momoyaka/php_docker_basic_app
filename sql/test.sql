INSERT INTO categories (name) VALUES ('Категория 1'), ('Категория 2'), ('Категория 3');
INSERT INTO products (name, category_id, price) VALUES
                                                    ('Телефон', 1, 700),
                                                    ('Ноутбук', 1, 1500),
                                                    ('Футболка', 2, 100),
                                                    ('Джинсы', 2, 125),
                                                    ('Карандаш', 3, 1.25);
INSERT INTO orders (product_id, quantity) VALUES (1, 2), (3, 5);