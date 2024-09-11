ALTER TABLE cours
    ADD COLUMN IF NOT EXISTS created_on timestamp default now(),
    ADD COLUMN IF NOT EXISTS updated_on timestamp,
    ADD COLUMN IF NOT EXISTS deleted_on timestamp,
    ALTER COLUMN source_id DROP NOT NULL,
    ALTER COLUMN source_code DROP NOT NULL,
    ALTER COLUMN histo_createur_id DROP NOT NULL;

ALTER TABLE formation
    ADD COLUMN IF NOT EXISTS created_on timestamp default now(),
    ADD COLUMN IF NOT EXISTS updated_on timestamp,
    ADD COLUMN IF NOT EXISTS deleted_on timestamp,
    ALTER COLUMN source_id DROP NOT NULL,
    ALTER COLUMN source_code DROP NOT NULL,
    ALTER COLUMN histo_createur_id DROP NOT NULL;

ALTER TABLE import_formation
    ADD COLUMN IF NOT EXISTS type_formation_id bigint,
    ADD COLUMN IF NOT EXISTS langue_enseignement_id bigint;