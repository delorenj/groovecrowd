App.Project = Backbone.Model.extend({
    defaults: {
        title: "",
        description: "",
        organizaion: "",
        payoutGuaranteed: "",
        protection: "",
        contestLength: "",
        enabled: "",
        fullGrooveSetsOnly: "",
        blind: "",
        flags: "",
        projectType: "",
        createdAt: "",
        modifiedAt: "",
        category: "",
        assets: ""
    },

    expiresIn: function() {
        return this.get('contestLength');
    }
});
