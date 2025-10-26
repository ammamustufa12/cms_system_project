DROP TABLE IF EXISTS product_content_meta;

DROP SEQUENCE IF EXISTS product_content_meta_seq;
CREATE SEQUENCE product_content_meta_seq;
-- SELECT setval('product_content_meta_seq', 0, true); -- last inserted id by sample data

CREATE TABLE product_content_meta (
  "product_id" int check ("product_id" > 0) NOT NULL,
  "language_id" int check ("language_id" > 0) NOT NULL,
  "namespace" varchar(32) NOT NULL DEFAULT '',
  "key" varchar(191) NOT NULL,
  "value" text DEFAULT NULL
);

CREATE UNIQUE INDEX "product_content_meta_product_id" ON product_content_meta ("product_id","language_id","namespace","key");
