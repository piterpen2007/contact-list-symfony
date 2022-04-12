--
-- PostgreSQL database dump
--

-- Dumped from database version 14.2
-- Dumped by pg_dump version 14.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: address_status; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.address_status (id, name) VALUES (1, 'Work');
INSERT INTO public.address_status (id, name) VALUES (2, 'Home');


--
-- Data for Name: address; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.address (id_address, address, status_id) VALUES (24, 'Улица спида', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (12, 'Школьная', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (9, 'Школьная', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (5, '', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (4, '', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (3, '', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (2, '', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (1, '', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (28, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (27, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (26, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (25, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (23, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (22, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (21, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (19, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (16, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (14, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (11, 'Крутая', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (10, 'Крутая', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (8, 'Школьная', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (7, 'Школьная', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (6, 'Школьная', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (40, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (41, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (42, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (43, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (44, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (45, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (46, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (47, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (48, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (49, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (50, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (51, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (52, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (53, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (54, 'dhdfh', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (55, 'минина', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (56, 'Ждановский, ул.Школьная, д30', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (57, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (58, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (59, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (60, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (61, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (62, 'Это адрес контакта', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (94, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (104, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (106, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (111, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (113, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (118, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (124, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (126, 'Минина, 9, Православный дом', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (128, 'Минина, 9, Православный дом', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (130, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (132, 'Привет, надеюсь ты работаешь', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (134, 'Привет, надеюсь ты работаешь', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (136, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (138, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (140, 'Это адрес контакта для теста доктрины', 2);
INSERT INTO public.address (id_address, address, status_id) VALUES (142, '5', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (144, '5', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (146, '5', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (148, '5', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (150, '5', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (152, '5', 1);
INSERT INTO public.address (id_address, address, status_id) VALUES (154, '5', 1);


--
-- Data for Name: recipients; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (1, 'Осипов Геннадий Иванович', '1985-06-15', 'Системный администратор', 'recipient');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (2, 'Тамара', '1990-06-06', '', 'recipient');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (3, 'Дамир Авто', '1990-12-01', 'Автомеханик', 'recipient');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (4, 'Катя', '1989-03-08', '', 'recipient');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (5, 'Шипенко Леонид Иосифович', '1969-02-07', 'Слесарь', 'recipient');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (6, 'Дед', '1945-06-04', 'Столяр', 'kinsfolk');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (7, 'Калинин Пётр Александрович', '1983-06-04', 'Фитнес тренер', 'customer');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (8, 'Васин Роман Александрович', '1977-01-04', 'Фитнес тренер', 'customer');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (9, 'Стрелецкая Анастасия Виктоовна', '1980-12-30', 'Админимстратор фитнес центра', 'customer');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (10, 'Шатов Александр Иванович', '1971-12-02', '', 'colleague');
INSERT INTO public.recipients (id_recipient, full_name, birthday, profession, type) VALUES (11, 'Наташа', '1984-05-10', '', 'colleague');


--
-- Data for Name: address_to_recipients; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (1, 1, 1);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (2, 2, 1);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (3, 3, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (4, 4, 3);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (5, 5, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (6, 6, 7);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (7, 7, 7);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (8, 8, 7);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (9, 9, 8);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (10, 10, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (11, 11, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (12, 12, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (13, 14, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (14, 16, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (15, 19, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (16, 21, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (17, 22, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (18, 23, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (19, 24, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (20, 25, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (21, 26, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (22, 27, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (23, 28, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (24, 10, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (25, 10, 3);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (26, 10, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (27, 48, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (28, 48, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (29, 49, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (30, 49, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (31, 50, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (32, 50, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (33, 52, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (34, 52, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (35, 53, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (36, 53, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (37, 54, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (38, 54, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (39, 55, 9);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (40, 55, 6);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (41, 56, 3);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (42, 56, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (43, 56, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (44, 56, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (45, 56, 1);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (46, 56, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (47, 56, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (48, 56, 8);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (49, 56, 9);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (50, 56, 7);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (51, 56, 6);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (52, 57, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (53, 57, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (54, 58, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (55, 58, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (56, 59, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (57, 59, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (58, 60, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (59, 60, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (60, 61, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (61, 61, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (62, 62, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (63, 62, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (65, 94, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (66, 104, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (67, 106, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (68, 111, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (69, 113, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (70, 118, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (71, 118, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (72, 118, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (73, 118, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (74, 124, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (75, 124, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (76, 124, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (77, 124, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (78, 126, 6);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (79, 126, 9);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (80, 128, 6);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (81, 128, 9);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (82, 130, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (83, 130, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (84, 130, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (85, 130, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (86, 132, 1);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (87, 132, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (88, 132, 3);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (89, 134, 1);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (90, 134, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (91, 134, 3);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (92, 136, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (93, 136, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (94, 136, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (95, 136, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (96, 138, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (97, 138, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (98, 138, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (99, 138, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (100, 140, 2);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (101, 140, 5);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (102, 140, 10);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (103, 140, 11);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (104, 142, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (105, 144, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (106, 146, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (107, 148, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (108, 150, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (109, 152, 4);
INSERT INTO public.address_to_recipients (address_to_recipients_id, id_address, id_recipient) VALUES (110, 154, 4);


--
-- Data for Name: colleagues; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.colleagues (id_recipient, department, "position", room_number) VALUES (10, 'Дирекция', 'Директор', '405');
INSERT INTO public.colleagues (id_recipient, department, "position", room_number) VALUES (11, 'Дирекция', 'Секретарь', '404');


--
-- Data for Name: contact_list; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (1, 1, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (2, 2, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (3, 3, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (4, 4, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (5, 5, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (8, 8, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (9, 9, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (10, 10, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (11, 11, false);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (7, 7, true);
INSERT INTO public.contact_list (id_entry, id_recipient, blacklist) VALUES (6, 6, true);


--
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.customers (id_recipient, contract_number, average_transaction_amount, discount, time_to_call) VALUES (7, '5684', 2500, '5%', 'С 9:00 до 13:00 в будни');
INSERT INTO public.customers (id_recipient, contract_number, average_transaction_amount, discount, time_to_call) VALUES (8, '5683', 9500, '10%', 'С 12:00 до 16:00 в будни');
INSERT INTO public.customers (id_recipient, contract_number, average_transaction_amount, discount, time_to_call) VALUES (9, '5682', 15200, '10%', 'С 17:00 до 19:00 в будни');


--
-- Data for Name: email; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.email (id, type_email, email, recipient_id) VALUES (1, 'Yandex', 'pipetka@yandex.ru', 8);
INSERT INTO public.email (id, type_email, email, recipient_id) VALUES (2, 'Google', 'kuku@gmail.com', 3);
INSERT INTO public.email (id, type_email, email, recipient_id) VALUES (3, 'Rambler', 'pochta@rambler.com', 3);


--
-- Data for Name: kinsfolk; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.kinsfolk (id_recipient, status, ringtone, hotkey) VALUES (6, 'Дед', 'Bells', '1');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users (id, login, password) VALUES (1, 'admin', '$2y$10$wvtXiHCmXEtmDC3rBZrD8eej4ZwiKzaSwtd3.sJJH9v8wxzDGS2DG');


--
-- Name: address_id_address_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.address_id_address_seq', 154, true);


--
-- Name: address_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.address_status_id_seq', 44, true);


--
-- Name: address_to_recipients_address_to_recipients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.address_to_recipients_address_to_recipients_id_seq', 110, true);


--
-- Name: contact_list_id_entry_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.contact_list_id_entry_seq', 11, true);


--
-- Name: email_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.email_id_seq', 3, true);


--
-- Name: recipients_id_recipient_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.recipients_id_recipient_seq', 11, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- PostgreSQL database dump complete
--

