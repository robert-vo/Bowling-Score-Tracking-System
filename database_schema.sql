drop table if exists stores;

DROP TABLE if exists employees;

CREATE TABLE employees (
    emp_id INT auto_increment primary key, 
    first_name VARCHAR(20), 
    last_name VARCHAR(30)
);

create table stores (
    storeID INT auto_increment primary key,
    store_name VARCHAR(30),
    store_location VARCHAR(30),
    manager_id int,
    regional_manager_id int,
    foreign key (manager_id) references employees(emp_id),
    foreign key (regional_manager_id) references employees(emp_id)
);

INSERT INTO employees (first_name, last_name) VALUES ('John', 'Doe');
INSERT INTO employees (first_name, last_name) VALUES ('Bob', 'Smith');
INSERT INTO employees (first_name, last_name) VALUES ('Jane', 'Doe');

INSERT INTO stores (store_name, 
		store_location, 
        	manager_id, 
        	regional_manager_id) 
	VALUES ('McDonalds', 'Houston, TX', 2, 1);
       
INSERT INTO stores (store_name, 
		store_location, 
                manager_id, 
                regional_manager_id) 
	VALUES ('McDonalds', 'Austin, TX', 3, 1);

-- should fail since an employee id of 4 does not exist. 
INSERT INTO stores (store_name, 
		store_location, 
                manager_id, 
                regional_manager_id) 
	VALUES ('McDonalds', 'Austin, TX', 4, 1);

SELECT * FROM employees;
select * from stores; --displays only two rows.
