INSERT INTO Memberships (membership_type, status, price) VALUES
('Basic', 'Active', 29.99),
('Premium', 'Active', 49.99),
('Student', 'Active', 19.99),
('VIP', 'Inactive', 79.99);

INSERT INTO Clients (first_name, last_name, email, street, city, state, zip, country, Memberships_membership_id) VALUES
('John', 'Smith', 'johns@example.com', '123 Main St', 'Taylor', 'MI', '48180', 'USA', 2),
('Ava', 'Johnson', 'ava@example.com', '456 Oak Ave', 'Detroit', 'MI', '48201', 'USA', 1),
('Liam', 'Smith', 'liam@example.com', '789 Pine Rd', 'Southfield', 'MI', '48075', 'USA', 3),
('Mia', 'Brown', 'mia@example.com', '321 Maple Dr', 'Dearborn', 'MI', '48124', 'USA', 1);

INSERT INTO Employees (first_name, last_name, position, hire_date) VALUES
('Chris', 'Adams', 'Trainer', '2023-01-10'),
('Nina', 'Lopez', 'Nutritionist', '2022-08-15'),
('Marcus', 'Hill', 'Manager', '2021-05-20'),
('Sophia', 'Reed', 'Yoga Instructor', '2024-02-01');

INSERT INTO Classes (class_name, schedule_time, Employees_employee_id) VALUES
('Morning Yoga', '2026-04-15 08:00:00', 4),
('HIIT Blast', '2026-04-15 18:00:00', 1),
('Strength Basics', '2026-04-16 17:30:00', 1),
('Nutrition 101', '2026-04-17 12:00:00', 2);

INSERT INTO Class_Registrations (Clients_client_id, Classes_class_id) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 4),
(4, 3);

INSERT INTO Invoices (payment_date, total_amount, Clients_client_id) VALUES
('2026-04-01', 49.99, 1),
('2026-04-02', 59.98, 2),
('2026-04-03', 19.99, 3),
('2026-04-04', 89.99, 4);

INSERT INTO Nutrition_Products (product_name, price, description, Invoices_invoice_id) VALUES
('Protein Powder', 39.99, 'Whey protein, cocoa, natural flavor, and vitamins', 1),
('Berry Blast Smoothie', 8.99, 'Strawberries, blueberries, banana, yogurt, and honey', 2),
('Creatine Mix', 24.99, 'Creatine monohydrate performance supplement', 3),
('Green Energy Smoothie', 7.99, 'Spinach, mango, pineapple, banana, and coconut water', 4);

INSERT INTO Equipment (type, last_maintenance_date, Invoices_invoice_id) VALUES
('Treadmill', '2026-03-15', 1),
('Bench Press', '2026-03-20', 2),
('Dumbbell Set', '2026-03-25', 3),
('Rowing Machine', '2026-03-30', 4);
