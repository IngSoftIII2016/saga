USE gestion_aulas;

INSERT INTO sede (id, nombre) VALUES (NULL, 'Atlántica');

INSERT INTO localidad (id, nombre, Sede_id) VALUES (NULL, 'Viedma', '1');

INSERT INTO edificio (id, nombre, Localidad_id) VALUES (NULL, 'Campus', '1');

INSERT INTO aula (id, nombre, capacidad, Edificio_id) VALUES 
(NULL, 'Aula 1', '50', '1'), 
(NULL, 'Aula 2', '50', '1'), 
(NULL, 'Aula 3', '50', '1'), 
(NULL, 'Aula 4', '50', '1'), 
(NULL, 'Aula 5', '50', '1'), 
(NULL, 'Aula 6', '50', '1'), 
(NULL, 'Aula 7', '50', '1'), 
(NULL, 'Aula 8', '50', '1'), 
(NULL, 'Aula 9', '50', '1'), 
(NULL, 'Aula 10', '30', '1'), 
(NULL, 'Aula Magna', '200', '1'), 
(NULL, 'Laboratorio de Informática Aplicada', '20', '1'), 
(NULL, 'Aula de Infromática', '24', '1'), 
(NULL, 'Laboratorio de Docencia 1', '30', '1'), 
(NULL, 'Laboratorio de Docencia 2', '18', '1'), 
(NULL, 'Laboratorio de Docencia 3', '30', '1'), 
(NULL, 'Laboratorio de Docencia 4', '18', '1');
