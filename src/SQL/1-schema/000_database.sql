DO $$
    DECLARE
        r record;
    BEGIN
        FOR r IN SELECT quote_ident(tablename) AS tablename, quote_ident(schemaname) AS schemaname FROM pg_tables WHERE schemaname = 'public'
            LOOP
                RAISE INFO 'Dropping table %.%', r.schemaname, r.tablename;
                EXECUTE format('DROP TABLE IF EXISTS %I.%I CASCADE', r.schemaname, r.tablename);
            END LOOP;
END$$;