CREATE DATABASE IF NOT EXISTS volunteer_system;
USE volunteer_system;

CREATE TABLE volunteers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    age INT,
    address TEXT,
    skills TEXT,
    availability VARCHAR(50),
    event_preference VARCHAR(100),
    resume_path VARCHAR(255),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_name VARCHAR(100) NOT NULL,
    event_date DATE,
    location VARCHAR(100),
    description TEXT
);

INSERT INTO events (event_name, event_date, location, description) VALUES
('Community Cleanup Drive', '2025-01-15', 'Central Park', 'Help clean our community parks'),
('Food Distribution Event', '2025-01-20', 'Community Center', 'Distribute food to those in need'),
('Educational Workshop', '2025-01-25', 'Public Library', 'Teaching basic computer skills'),
('Health Camp', '2025-02-01', 'City Hospital', 'Free health checkup camp'),
('Tree Plantation Drive', '2025-02-10', 'Riverside Area', 'Plant trees for a greener future');