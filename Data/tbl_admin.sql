PGDMP     8    :                {         
   thuocsi.vn    13.11    13.11     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16849 
   thuocsi.vn    DATABASE     p   CREATE DATABASE "thuocsi.vn" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'English_United States.1252';
    DROP DATABASE "thuocsi.vn";
                postgres    false            �            1259    17425 	   tbl_admin    TABLE     �   CREATE TABLE public.tbl_admin (
    id integer NOT NULL,
    fullname text,
    email character(255),
    phone character(10),
    username character(255),
    password character(255),
    type integer
);
    DROP TABLE public.tbl_admin;
       public         heap    postgres    false            �            1259    17423    tbl_admin_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tbl_admin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.tbl_admin_id_seq;
       public          postgres    false    211            �           0    0    tbl_admin_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.tbl_admin_id_seq OWNED BY public.tbl_admin.id;
          public          postgres    false    210            D           2604    17428    tbl_admin id    DEFAULT     l   ALTER TABLE ONLY public.tbl_admin ALTER COLUMN id SET DEFAULT nextval('public.tbl_admin_id_seq'::regclass);
 ;   ALTER TABLE public.tbl_admin ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    211    210    211            �          0    17425 	   tbl_admin 
   TABLE DATA           Y   COPY public.tbl_admin (id, fullname, email, phone, username, password, type) FROM stdin;
    public          postgres    false    211          �           0    0    tbl_admin_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.tbl_admin_id_seq', 10, true);
          public          postgres    false    210            F           2606    17433    tbl_admin tbl_admin_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.tbl_admin
    ADD CONSTRAINT tbl_admin_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.tbl_admin DROP CONSTRAINT tbl_admin_pkey;
       public            postgres    false    211            �   A  x��1N�0���S����i�u逐�P'*�R�!�:W�00�017#�{�&<G`(��7<����W�8N4L�<o��r�tX��p���خ�r5h6k��Y^�QU+,��%�B=��+�C� ����O)d_�<��ϯESx�c˸v;Q@Ue���g���m�3�S��>�ä�1I���Z�I�c����Wԣ��z����G�&[�L�H<r�r5�2�v���ϯD���IVD��W��3�/}w���u��	LB�ޠ"߿����z4RA����	���k����w�β�ˡ��
4%�������B }�!�a��     