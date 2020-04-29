const methods = {
    init() {
        this.getValue();
        Fjord.bus.$on('languageChanged', this.getValue);
    },
    getValue() {
        this.value = this._getValue();
        this.$forceUpdate();
    },
    _getValue() {
        let locale = this.$store.state.config.language;
        let fallbackLocale = this.$store.state.config.fallback_locale;

        this.setDefaultCastValues();

        if (!this.shouldStoreToTranslation()) {
            return this.model[this.field.id];
        }

        if (this.shouldUseFallback()) {
            return this.model[fallbackLocale][this.field.id];
        }

        return this.model[locale][this.field.id];
    },
    setValue(value) {
        this._setValue(value);
        this.getValue();
        this.addSaveJob(value);
    },
    _setValue(value) {
        let locale = this.$store.state.config.language;
        let fallbackLocale = this.$store.state.config.fallback_locale;

        if (!this.shouldStoreToTranslation()) {
            return (this.model[this.field.local_key] = value);
        }

        if (this.shouldUseFallback()) {
            return (this.model[fallbackLocale][this.field.local_key] = value);
        }

        this.model[locale][this.field.local_key] = value;
    },
    setDefaultCastValues() {
        let locale = this.$store.state.config.language;
        let fallbackLocale = this.$store.state.config.fallback_locale;

        if (!this.shouldStoreToTranslation()) {
            return;
        }

        if (!this.model[locale]) {
            this.model[locale] = {
                [this.field.local_key]: null
            };
        }
        if (!this.model[fallbackLocale]) {
            this.model[fallbackLocale] = {
                [this.field.local_key]: null
            };
        }
    },
    shouldUseFallback() {
        return (
            !this.field.translatable &&
            this.model.usesJsonCast() &&
            this.model.translatable
        );
    },
    shouldStoreToTranslation() {
        if (!this.field.translatable && !this.model.translatable) {
            return false;
        }

        if (!this.field.translatable && !this.model.usesJsonCast()) {
            return false;
        }

        return true;
    },
    addSaveJob(value) {
        let locale = this.$store.state.config.language;
        let params = {};
        let removeParams = '';

        if (this.shouldStoreToTranslation()) {
            let locale = this.$store.state.config.language;
            if (this.shouldUseFallback()) {
                locale = this.$store.state.config.fallback_locale;
            }
            removeParams = `${locale}.${this.field.local_key}`;
            params[locale] = {
                [this.field.local_key]: value
            };
        } else {
            removeParams = `${this.field.local_key}`;
            params[this.field.local_key] = value;
        }

        let job = {
            route: this.field.route_prefix,
            method: 'PUT',
            params
        };

        this.$store.commit('ADD_SAVE_JOB', job);

        // TODO: Remove save job if has no changes:

        /*
        if (this.model.hasChanges()) {
            this.$store.commit('ADD_SAVE_JOB', job);
        } else {
            job.params = removeParams;
            this.$store.commit('REMOVE_SAVE_JOB', job);
        }
        */
    }
};

export default methods;
