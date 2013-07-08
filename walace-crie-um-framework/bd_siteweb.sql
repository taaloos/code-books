--
-- PostgreSQL database dump
--

-- Started on 2009-04-07 09:13:02

SET client_encoding = 'SQL_ASCII';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1479 (class 1259 OID 16414)
-- Dependencies: 1754 6
-- Name: auditoria; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE auditoria (
    auditoria_id integer DEFAULT 1 NOT NULL,
    usuario_login character varying(20) NOT NULL,
    ip character varying(60),
    classe character varying(60),
    data timestamp without time zone,
    funcao character(3),
    historico text
);


--
-- TOC entry 1481 (class 1259 OID 16438)
-- Dependencies: 6
-- Name: favoritos; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE favoritos (
    usuario_id integer NOT NULL,
    programa character varying(120) NOT NULL
);


--
-- TOC entry 1480 (class 1259 OID 16429)
-- Dependencies: 1755 6
-- Name: historico; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE historico (
    usuario_id integer NOT NULL,
    programa character varying(120) NOT NULL,
    acessos integer DEFAULT 1
);


--
-- TOC entry 1475 (class 1259 OID 16386)
-- Dependencies: 1748 1749 6
-- Name: menu; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE menu (
    menu_id integer NOT NULL,
    menu_desc character varying(30) NOT NULL,
    menu_prog character varying(120) DEFAULT '<menu>'::character varying NOT NULL,
    menu_icon character varying(120),
    menu_pai integer DEFAULT 0
);


--
-- TOC entry 1476 (class 1259 OID 16391)
-- Dependencies: 1750 1751 6
-- Name: permissao; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE permissao (
    usuario_id integer DEFAULT 0 NOT NULL,
    menu_id integer NOT NULL,
    permissao_modo character(3) DEFAULT 'NEG'::bpchar
);


--
-- TOC entry 1477 (class 1259 OID 16396)
-- Dependencies: 1752 6
-- Name: tab_teste; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tab_teste (
    codigo integer DEFAULT 0 NOT NULL,
    descricao character varying(20),
    valor double precision
);


--
-- TOC entry 1478 (class 1259 OID 16400)
-- Dependencies: 1753 6
-- Name: usuario; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE usuario (
    usuario_id integer NOT NULL,
    usuario_nome character varying(60) NOT NULL,
    usuario_login character varying(20) NOT NULL,
    usuario_senha character varying(30) NOT NULL,
    usuario_email character varying(120),
    usuario_ativo integer DEFAULT 1
);


--
-- TOC entry 1767 (class 2606 OID 16422)
-- Dependencies: 1479 1479
-- Name: auditoria_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY auditoria
    ADD CONSTRAINT auditoria_pkey PRIMARY KEY (auditoria_id);


--
-- TOC entry 1763 (class 2606 OID 16405)
-- Dependencies: 1478 1478
-- Name: chv_login; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT chv_login UNIQUE (usuario_login);


--
-- TOC entry 1771 (class 2606 OID 16442)
-- Dependencies: 1481 1481 1481
-- Name: favoritos_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY favoritos
    ADD CONSTRAINT favoritos_pkey PRIMARY KEY (usuario_id, programa);


--
-- TOC entry 1769 (class 2606 OID 16434)
-- Dependencies: 1480 1480 1480
-- Name: historico_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY historico
    ADD CONSTRAINT historico_pkey PRIMARY KEY (usuario_id, programa);


--
-- TOC entry 1757 (class 2606 OID 16407)
-- Dependencies: 1475 1475
-- Name: menu_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (menu_id);


--
-- TOC entry 1759 (class 2606 OID 16409)
-- Dependencies: 1476 1476 1476
-- Name: permissao_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY permissao
    ADD CONSTRAINT permissao_pkey PRIMARY KEY (usuario_id, menu_id);


--
-- TOC entry 1761 (class 2606 OID 16411)
-- Dependencies: 1477 1477
-- Name: tab_teste_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tab_teste
    ADD CONSTRAINT tab_teste_pkey PRIMARY KEY (codigo);


--
-- TOC entry 1765 (class 2606 OID 16413)
-- Dependencies: 1478 1478
-- Name: usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (usuario_id);


--
-- TOC entry 1776 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2009-04-07 09:13:03

--
-- PostgreSQL database dump complete
--

