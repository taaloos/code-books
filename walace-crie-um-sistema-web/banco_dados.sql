--
-- PostgreSQL database dump
--

-- Started on 2009-05-28 11:32:31

SET client_encoding = 'SQL_ASCII';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 1896 (class 1262 OID 16443)
-- Name: sistemaweb; Type: DATABASE; Schema: -; Owner: -
--

CREATE DATABASE sistemaweb WITH TEMPLATE = template0 ENCODING = 'SQL_ASCII';

\connect sistemaweb

SET client_encoding = 'SQL_ASCII';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1498 (class 1259 OID 16444)
-- Dependencies: 1782 6
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
-- TOC entry 1503 (class 1259 OID 16497)
-- Dependencies: 6
-- Name: carro; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE carro (
    codigo integer NOT NULL,
    marca character varying(50),
    modelo character varying(100),
    ano_fabricacao integer,
    ano_modelo integer,
    cor character varying(20)
);


--
-- TOC entry 1515 (class 1259 OID 16790)
-- Dependencies: 1813 1814 6
-- Name: contagem; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE contagem (
    inventario_codigo character varying(10) NOT NULL,
    produto_codigo character varying(20) NOT NULL,
    local_codigo character varying(10) NOT NULL,
    contagem_numero integer DEFAULT 1 NOT NULL,
    contagem_estoque numeric(10,3),
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1504 (class 1259 OID 16502)
-- Dependencies: 1788 1789 1790 6
-- Name: departamento; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE departamento (
    depto_codigo character varying(10) NOT NULL,
    depto_desc character varying(60) NOT NULL,
    depto_pai character varying(10) DEFAULT ''::character varying,
    depto_tipo integer DEFAULT 1,
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1512 (class 1259 OID 16693)
-- Dependencies: 1806 6
-- Name: estoquelocal; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE estoquelocal (
    produto_codigo character varying(20) NOT NULL,
    local_codigo character varying(10) NOT NULL,
    produto_estoque numeric(10,3),
    produto_custoatual numeric(12,3),
    produto_customedio numeric(12,3),
    produto_ac_ent_qde numeric(18,3),
    produto_ac_ent_vlr numeric(18,3),
    produto_ac_saidas numeric(18,3),
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1499 (class 1259 OID 16451)
-- Dependencies: 6
-- Name: favoritos; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE favoritos (
    usuario_id integer NOT NULL,
    programa character varying(120) NOT NULL
);


--
-- TOC entry 1505 (class 1259 OID 16516)
-- Dependencies: 1791 6
-- Name: grupo; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE grupo (
    grupo_codigo character varying(10) NOT NULL,
    grupo_desc character varying(60) NOT NULL,
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1511 (class 1259 OID 16657)
-- Dependencies: 1805 6
-- Name: historico; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE historico (
    usuario_id integer NOT NULL,
    programa character varying(120) NOT NULL,
    acessos integer DEFAULT 1
);


--
-- TOC entry 1510 (class 1259 OID 16640)
-- Dependencies: 1801 1802 1803 1804 6
-- Name: historicomovimento; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE historicomovimento (
    produto_codigo character varying(20) NOT NULL,
    local_codigo character varying(10) NOT NULL,
    historico_data date NOT NULL,
    historico_sequencia bigint NOT NULL,
    tipomov_codigo character varying(10) NOT NULL,
    tipomov_tipo character(1) DEFAULT 'E'::bpchar NOT NULL,
    historico_documento character varying(20),
    historico_historico text,
    historico_quantidade numeric(10,3),
    historico_valor_unit numeric(12,3),
    historico_valor_total numeric(12,3),
    historico_estorno character(1) DEFAULT 'N'::bpchar,
    historico_estorno_seq bigint,
    historico_estornado character(1) DEFAULT 'N'::bpchar,
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1513 (class 1259 OID 16750)
-- Dependencies: 1807 1808 1809 1810 1811 6
-- Name: inventario; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE inventario (
    inventario_codigo character varying(10) NOT NULL,
    inventario_desc character varying(30) NOT NULL,
    inventario_data_prevista date NOT NULL,
    inventario_data_real date,
    inventario_congelado character(1) DEFAULT 'N'::bpchar,
    inventario_contagem integer DEFAULT 1,
    inventario_consolidado character(1) DEFAULT 'N'::bpchar,
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL,
    local_codigo character varying(10) DEFAULT 'TODOS'::character varying
);


--
-- TOC entry 1514 (class 1259 OID 16764)
-- Dependencies: 1812 6
-- Name: inventarioproduto; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE inventarioproduto (
    inventario_codigo character varying(10) NOT NULL,
    produto_codigo character varying(20) NOT NULL,
    local_codigo character varying(10) NOT NULL,
    produto_customedio numeric(12,3),
    produto_estoque numeric(10,3),
    inventario_estoque numeric(10,3),
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1508 (class 1259 OID 16585)
-- Dependencies: 1794 1795 6
-- Name: localestoque; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE localestoque (
    local_codigo character varying(10) NOT NULL,
    local_desc character varying(30) NOT NULL,
    local_tipo character(1) DEFAULT 'L'::bpchar,
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1500 (class 1259 OID 16458)
-- Dependencies: 1783 1784 6
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
-- TOC entry 1501 (class 1259 OID 16463)
-- Dependencies: 1785 1786 6
-- Name: permissao; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE permissao (
    usuario_id integer DEFAULT 0 NOT NULL,
    menu_id integer NOT NULL,
    permissao_modo character(3) DEFAULT 'NEG'::bpchar
);


--
-- TOC entry 1507 (class 1259 OID 16558)
-- Dependencies: 1793 6
-- Name: produto; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE produto (
    produto_codigo character varying(20) NOT NULL,
    produto_desc character varying(60) NOT NULL,
    produto_preco numeric(12,3),
    produto_custoatual numeric(12,3),
    produto_customedio numeric(12,3),
    depto_codigo character varying(10) NOT NULL,
    grupo_codigo character varying(10) NOT NULL,
    unidade_codigo character(4) NOT NULL,
    produto_peso numeric(10,5),
    produto_estoque numeric(10,3),
    produto_est_minimo numeric(10,3),
    produto_est_maximo numeric(10,3),
    produto_ac_ent_qde numeric(18,3),
    produto_ac_ent_vlr numeric(18,3),
    produto_ac_saidas numeric(18,3),
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1509 (class 1259 OID 16597)
-- Dependencies: 1796 1797 1798 1799 1800 6
-- Name: tipomovimento; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tipomovimento (
    tipomov_codigo character varying(10) NOT NULL,
    tipomov_desc character varying(30) NOT NULL,
    tipomov_tipo character(1) DEFAULT 'E'::bpchar NOT NULL,
    tipomov_estorno character(1) DEFAULT 'N'::bpchar NOT NULL,
    tipomov_customedio character(1) DEFAULT 'S'::bpchar NOT NULL,
    tipomov_custoatual character(1) DEFAULT 'S'::bpchar NOT NULL,
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 1506 (class 1259 OID 16552)
-- Dependencies: 1792 6
-- Name: unidade; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE unidade (
    unidade_codigo character(4) NOT NULL,
    unidade_desc character varying(20) NOT NULL,
    usuario_login character varying(20),
    data_ultima_alteracao timestamp without time zone DEFAULT now() NOT NULL
);

--
-- TOC entry 1878 (class 0 OID 16458)
-- Dependencies: 1500
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (3, 'Gerenciador de Menus', 'adm_menu.php5', 'menu.png', 2);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (11, 'Gerenciador de Usuários', 'adm_usuario.php5', 'user.png', 2);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (12, 'Permissões', 'adm_permissao.php5', 'permissoes.png', 2);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (14, 'Auditoria', 'adm_auditoria.php5', 'audit.png', 2);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (15, 'Estoque', '[menu]', '', -1);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (16, 'Carros', 'teste/man_carros.php5', 'CabrioletRed-32x32.png', 2);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (2, 'Administração', '[menu]', '', -1);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (17, 'Cadastros', '[menu]', '', 15);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (18, 'Departamentos', 'estoque/man_departamento.php5', '', 17);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (19, 'Grupos', 'estoque/man_grupo.php5', 'box-2-48x48.png', 17);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (20, 'Unidades de medida', 'estoque/man_unidade.php5', '', 17);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (21, 'Tipos de movimentos', 'estoque/man_tipomovimento.php5', '', 17);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (22, 'Produtos', 'estoque/man_produto.php5', 'flour-32x32.png', 17);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (23, 'Locias de Estoque', 'estoque/man_localestoque.php5', '', 17);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (26, 'Movimentação', '[menu]', '', 15);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (27, 'Entradas', 'estoque/mov_entradas.php5', '', 26);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (28, 'Saídas', 'estoque/mov_saidas.php5', '', 26);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (30, 'Estorno de Entradas', 'estoque/mov_estorno_entrada.php5', '', 26);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (31, 'Estorno de Saídas', 'estoque/mov_estorno_saida.php5', '', 26);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (32, 'Relatórios', '[menu]', '3-Gray-Paper-Box-32x32.png', 15);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (33, 'Saldo de produtos', 'estoque/rel_estoqueatual.php5', 'Calculator-32x32.png', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (34, 'Estoque por Departamento', 'estoque/rel_estoquedepto.php5', '', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (35, 'Estoque por Grupo de produtos', 'estoque/rel_estoquegrupo.php5', '', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (37, 'Estoque por Produto e Local', 'estoque/rel_estoqueatualprodutolocal.php5', '', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (38, 'Estoque acima do máximo', 'estoque/rel_estoqueacimamaximo.php5', '', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (39, 'Estoque Abaixo do mínimo', 'estoque/rel_estoqueabaixominimo.php5', '', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (40, 'Extrato de movimentação', 'estoque/rel_extratomovimento.php5', '', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (42, 'Curva ABC', 'estoque/rel_curvaabc.php5', 'pie.png', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (36, 'Estoque por Local', 'estoque/rel_estoqueatuallocal.php5', 'local.png', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (41, 'Razão de Estoque', 'estoque/rel_razaoestoque.php5', 'razao.png', 32);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (43, 'Inventário', '[menu]', '', 15);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (44, 'Cadastro de Inventário', 'estoque/inv_cadastroinventario.php5', 'pda.png', 43);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (45, 'Congelamento ', 'estoque/inv_congelarinventario.php5', '', 43);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (46, 'Ficha de Inventário', 'estoque/inv_fichainventario.php5', '', 43);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (47, 'Digitação de Contagem', 'estoque/inv_contagem.php5', '', 43);
INSERT INTO menu (menu_id, menu_desc, menu_prog, menu_icon, menu_pai) VALUES (48, 'Análise de Inventário', 'estoque/inv_analiseinventario.php5', '', 43);

--
-- TOC entry 1880 (class 0 OID 16472)
-- Dependencies: 1502
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO usuario (usuario_id, usuario_nome, usuario_login, usuario_senha, usuario_email, usuario_ativo) VALUES (1, 'Administrador', 'admin', 'SfCxXyng3gs=', '', 1);

--
-- TOC entry 1816 (class 2606 OID 16477)
-- Dependencies: 1498 1498
-- Name: auditoria_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY auditoria
    ADD CONSTRAINT auditoria_pkey PRIMARY KEY (auditoria_id);


--
-- TOC entry 1828 (class 2606 OID 16501)
-- Dependencies: 1503 1503
-- Name: carro_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY carro
    ADD CONSTRAINT carro_pkey PRIMARY KEY (codigo);


--
-- TOC entry 1824 (class 2606 OID 16479)
-- Dependencies: 1502 1502
-- Name: chv_login; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT chv_login UNIQUE (usuario_login);


--
-- TOC entry 1830 (class 2606 OID 16508)
-- Dependencies: 1504 1504
-- Name: departamento_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY departamento
    ADD CONSTRAINT departamento_pkey PRIMARY KEY (depto_codigo);


--
-- TOC entry 1847 (class 2606 OID 16698)
-- Dependencies: 1512 1512 1512
-- Name: estoquelocal_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY estoquelocal
    ADD CONSTRAINT estoquelocal_pkey PRIMARY KEY (produto_codigo, local_codigo);


--
-- TOC entry 1818 (class 2606 OID 16481)
-- Dependencies: 1499 1499 1499
-- Name: favoritos_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY favoritos
    ADD CONSTRAINT favoritos_pkey PRIMARY KEY (usuario_id, programa);


--
-- TOC entry 1832 (class 2606 OID 16521)
-- Dependencies: 1505 1505
-- Name: grupo_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY grupo
    ADD CONSTRAINT grupo_pkey PRIMARY KEY (grupo_codigo);


--
-- TOC entry 1845 (class 2606 OID 16662)
-- Dependencies: 1511 1511 1511
-- Name: historico_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY historico
    ADD CONSTRAINT historico_pkey PRIMARY KEY (usuario_id, programa);


--
-- TOC entry 1843 (class 2606 OID 16651)
-- Dependencies: 1510 1510 1510 1510 1510
-- Name: historicomovimento_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY historicomovimento
    ADD CONSTRAINT historicomovimento_pkey PRIMARY KEY (produto_codigo, local_codigo, historico_data, historico_sequencia);


--
-- TOC entry 1849 (class 2606 OID 16758)
-- Dependencies: 1513 1513
-- Name: inventario_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY inventario
    ADD CONSTRAINT inventario_pkey PRIMARY KEY (inventario_codigo);


--
-- TOC entry 1839 (class 2606 OID 16591)
-- Dependencies: 1508 1508
-- Name: localestoque_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY localestoque
    ADD CONSTRAINT localestoque_pkey PRIMARY KEY (local_codigo);


--
-- TOC entry 1820 (class 2606 OID 16485)
-- Dependencies: 1500 1500
-- Name: menu_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (menu_id);


--
-- TOC entry 1822 (class 2606 OID 16487)
-- Dependencies: 1501 1501 1501
-- Name: permissao_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY permissao
    ADD CONSTRAINT permissao_pkey PRIMARY KEY (usuario_id, menu_id);


--
-- TOC entry 1853 (class 2606 OID 16823)
-- Dependencies: 1515 1515 1515 1515 1515
-- Name: pk_contagem; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY contagem
    ADD CONSTRAINT pk_contagem PRIMARY KEY (inventario_codigo, produto_codigo, local_codigo, contagem_numero);


--
-- TOC entry 1851 (class 2606 OID 16769)
-- Dependencies: 1514 1514 1514 1514
-- Name: pk_inventarioproduto; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY inventarioproduto
    ADD CONSTRAINT pk_inventarioproduto PRIMARY KEY (inventario_codigo, produto_codigo, local_codigo);


--
-- TOC entry 1837 (class 2606 OID 16563)
-- Dependencies: 1507 1507
-- Name: produto_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY produto
    ADD CONSTRAINT produto_pkey PRIMARY KEY (produto_codigo);


--
-- TOC entry 1841 (class 2606 OID 16606)
-- Dependencies: 1509 1509
-- Name: tipomovimento_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tipomovimento
    ADD CONSTRAINT tipomovimento_pkey PRIMARY KEY (tipomov_codigo);


--
-- TOC entry 1834 (class 2606 OID 16557)
-- Dependencies: 1506 1506
-- Name: unidade_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY unidade
    ADD CONSTRAINT unidade_pkey PRIMARY KEY (unidade_codigo);


--
-- TOC entry 1826 (class 2606 OID 16491)
-- Dependencies: 1502 1502
-- Name: usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (usuario_id);


--
-- TOC entry 1835 (class 1259 OID 16584)
-- Dependencies: 1507
-- Name: fki_usuario; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX fki_usuario ON produto USING btree (usuario_login);


--
-- TOC entry 1856 (class 2606 OID 16564)
-- Dependencies: 1829 1504 1507
-- Name: fk_depto; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY produto
    ADD CONSTRAINT fk_depto FOREIGN KEY (depto_codigo) REFERENCES departamento(depto_codigo);


--
-- TOC entry 1857 (class 2606 OID 16569)
-- Dependencies: 1507 1831 1505
-- Name: fk_grupo; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY produto
    ADD CONSTRAINT fk_grupo FOREIGN KEY (grupo_codigo) REFERENCES grupo(grupo_codigo);


--
-- TOC entry 1870 (class 2606 OID 16770)
-- Dependencies: 1513 1848 1514
-- Name: fk_inventario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY inventarioproduto
    ADD CONSTRAINT fk_inventario FOREIGN KEY (inventario_codigo) REFERENCES inventario(inventario_codigo);


--
-- TOC entry 1873 (class 2606 OID 16797)
-- Dependencies: 1848 1513 1515
-- Name: fk_inventario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY contagem
    ADD CONSTRAINT fk_inventario FOREIGN KEY (inventario_codigo) REFERENCES inventario(inventario_codigo);


--
-- TOC entry 1864 (class 2606 OID 16683)
-- Dependencies: 1838 1510 1508
-- Name: fk_local; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY historicomovimento
    ADD CONSTRAINT fk_local FOREIGN KEY (local_codigo) REFERENCES localestoque(local_codigo);


--
-- TOC entry 1866 (class 2606 OID 16699)
-- Dependencies: 1512 1508 1838
-- Name: fk_local; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY estoquelocal
    ADD CONSTRAINT fk_local FOREIGN KEY (local_codigo) REFERENCES localestoque(local_codigo);


--
-- TOC entry 1863 (class 2606 OID 16678)
-- Dependencies: 1836 1510 1507
-- Name: fk_produto; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY historicomovimento
    ADD CONSTRAINT fk_produto FOREIGN KEY (produto_codigo) REFERENCES produto(produto_codigo);


--
-- TOC entry 1867 (class 2606 OID 16704)
-- Dependencies: 1512 1836 1507
-- Name: fk_produto; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY estoquelocal
    ADD CONSTRAINT fk_produto FOREIGN KEY (produto_codigo) REFERENCES produto(produto_codigo);


--
-- TOC entry 1871 (class 2606 OID 16775)
-- Dependencies: 1514 1507 1836
-- Name: fk_produto; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY inventarioproduto
    ADD CONSTRAINT fk_produto FOREIGN KEY (produto_codigo) REFERENCES produto(produto_codigo);


--
-- TOC entry 1874 (class 2606 OID 16802)
-- Dependencies: 1507 1836 1515
-- Name: fk_produto; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY contagem
    ADD CONSTRAINT fk_produto FOREIGN KEY (produto_codigo) REFERENCES produto(produto_codigo);


--
-- TOC entry 1865 (class 2606 OID 16688)
-- Dependencies: 1510 1840 1509
-- Name: fk_tipo; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY historicomovimento
    ADD CONSTRAINT fk_tipo FOREIGN KEY (tipomov_codigo) REFERENCES tipomovimento(tipomov_codigo);


--
-- TOC entry 1858 (class 2606 OID 16574)
-- Dependencies: 1833 1506 1507
-- Name: fk_unidade; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY produto
    ADD CONSTRAINT fk_unidade FOREIGN KEY (unidade_codigo) REFERENCES unidade(unidade_codigo);


--
-- TOC entry 1859 (class 2606 OID 16579)
-- Dependencies: 1502 1507 1823
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY produto
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1860 (class 2606 OID 16592)
-- Dependencies: 1823 1502 1508
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY localestoque
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1861 (class 2606 OID 16607)
-- Dependencies: 1509 1823 1502
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tipomovimento
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1862 (class 2606 OID 16652)
-- Dependencies: 1823 1502 1510
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY historicomovimento
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1868 (class 2606 OID 16709)
-- Dependencies: 1512 1502 1823
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY estoquelocal
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1869 (class 2606 OID 16759)
-- Dependencies: 1513 1502 1823
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY inventario
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1872 (class 2606 OID 16780)
-- Dependencies: 1514 1502 1823
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY inventarioproduto
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1875 (class 2606 OID 16807)
-- Dependencies: 1515 1823 1502
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY contagem
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1854 (class 2606 OID 16509)
-- Dependencies: 1504 1823 1502
-- Name: usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY departamento
    ADD CONSTRAINT usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1855 (class 2606 OID 16522)
-- Dependencies: 1823 1502 1505
-- Name: usuario; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY grupo
    ADD CONSTRAINT usuario FOREIGN KEY (usuario_login) REFERENCES usuario(usuario_login);


--
-- TOC entry 1898 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2009-05-28 11:32:32

--
-- PostgreSQL database dump complete
--

